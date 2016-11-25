<?php
namespace Cobweb\Batchmailer\Command;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Cobweb\Batchmailer\Domain\Repository\MailRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Command-line controller for sending all pending mails.
 *
 * @author Francois Suter <typo3@cobweb.ch>
 * @package batchmailer
 */
class MailerCommandController extends CommandController
{
    /**
     * @var MailRepository
     */
    protected $mailRepository;

    /**
     * @var array
     */
    protected $configuration = array();

    /**
     * Injects an instance of the mail repository.
     *
     * @param MailRepository $mailRepository
     */
    public function injectMailRepoository(MailRepository $mailRepository)
    {
        $this->mailRepository = $mailRepository;
    }

    /**
     * Sends all pending mails.
     *
     * Sends all mails that were stored in the database and that haven't been sent yet.
     *
     * @return void
     */
    public function sendCommand()
    {
        // Read the extension's configuration
        $this->configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['batchmailer']);
        // Override the batch transport
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = $this->configuration['originalTransport'];

        /** @var $mailsToSend \TYPO3\CMS\Extbase\Persistence\QueryResultInterface */
        $mailsToSend = $this->mailRepository->findBySent(false);

        // Numbers for reporting
        $mailsHandled = 0;
        $mailsSentSuccessfully = 0;

        /** @var $aMail \Cobweb\Batchmailer\Domain\Model\Mail */
        foreach ($mailsToSend as $aMail) {
            $mailsHandled++;
            try {
                // It seems that the mail object is not automatically unserialized, do it "manually" here
                /** @var $mailObject \TYPO3\CMS\Core\Mail\MailMessage */
                $mailObject = unserialize($aMail->getMail());
                // Restore the attachments
                $attachmentsList = $aMail->getAttachments();
                if (!empty($attachmentsList)) {
                    $attachments = explode(',', $attachmentsList);
                    foreach ($attachments as $aFile) {
                        $mailObject->attach(
                                \Swift_Attachment::fromPath($aFile)->setFilename(basename($aFile))
                        );
                    }
                }
                $result = $mailObject->send();
                $failedRecipients = $mailObject->getFailedRecipients();
                // Mark the mail as sent
                $aMail->setSent(true);
                $aMail->setSentDate(new \DateTime());
                // If it was sent to no one, set status to error and add list of failed recipients
                if ($result === 0) {
                    $aMail->setSentStatus(3);
                    $aMail->setSentErrorMessage('Failed sending the mail to ' . implode(', ', $failedRecipients));

                } else {
                    // If it was sent to at least one person and there are no failed recipients,
                    // mark it as a success
                    if (count($failedRecipients) === 0) {
                        $aMail->setSentStatus(6);
                        // Make sure no error message from a previous try is left over
                        $aMail->setSentErrorMessage('');
                        $mailsSentSuccessfully++;

                        // Otherwise set status to warning and issue list of failed recipients
                    } else {
                        $aMail->setSentStatus(4);
                        $aMail->setSentErrorMessage('Failed sending the mail to ' . implode(', ', $failedRecipients));
                    }
                }
            } catch (\Exception $e) {
                // If an exception happened, the mail is considered to be not sent, and the exception is logged
                $aMail->setSentDate(new \DateTime());
                $aMail->setSentStatus(3);
                $aMail->setSentErrorMessage($e->getMessage() . ' (' . $e->getCode() . ')');
            }
            // Whatever the result, raise number of tries
            $aMail->setSentTries($aMail->getSentTries() + 1);
            $this->mailRepository->update($aMail);
        }

        // Report about the execution
        if ($mailsHandled === 0) {
            $this->outputLine('No mails to handle');
        } else {
            $this->outputLine(sprintf('%d mails were handled, %d sent successfully.', $mailsHandled,
                    $mailsSentSuccessfully));
        }
    }
}
