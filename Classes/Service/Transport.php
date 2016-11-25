<?php
namespace Cobweb\Batchmailer\Service;

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

use Cobweb\Batchmailer\Domain\Model\Mail;
use Cobweb\Batchmailer\Domain\Repository\MailRepository;
use Cobweb\Batchmailer\Utility\Format;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Mail Transport which stores all mails in a database table, to be sent later by a Scheduler task.
 *
 * @author Francois Suter <typo3@cobweb.ch>
 * @package batchmailer
 */
class Transport implements \Swift_Transport
{
    /**
     * @var MailRepository
     */
    protected $mailRepository;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Instance of the persistence manager
     *
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @var array
     */
    protected $configuration = array();

    public function __construct($settings)
    {
        // Initialize objects manually, as the full Extbase context is not loaded and we cannot rely
        // on dependency injection at this point
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->mailRepository = $this->objectManager->get(MailRepository::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        // Read the extension's configuration
        $this->configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['batchmailer']);
    }

    /**
     * Tests if this Transport mechanism has started.
     *
     * Not used.
     *
     * @return boolean
     */
    public function isStarted()
    {
        return false;
    }

    /**
     * Starts this Transport mechanism.
     *
     * Not used.
     */
    public function start()
    {
        // TODO: Implement start() method.
    }

    /**
     * Stops this Transport mechanism.
     *
     * Not used.
     */
    public function stop()
    {
        // TODO: Implement stop() method.
    }

    /**
     * Stores the given message in the database.
     *
     * With this transport, messages are not sent right away, but stored in the database
     * to be sent at a later stage.
     *
     * @param \Swift_Mime_Message $message
     * @param string[] &$failedRecipients to collect failures by-reference
     * @return int
     */
    public function send(\Swift_Mime_Message $message, &$failedRecipients = null)
    {
        // Create the Mail object and set its values
        /** @var $newMail Mail */
        $newMail = $this->objectManager->get('Cobweb\\Batchmailer\\Domain\\Model\\Mail');
        $newMail->setPid($this->getStoragePage());
        $newMail->setSubject($message->getSubject());
        $newMail->setBody($message->getBody());
        $newMail->setRecipients(Format::formatListOfNames($message->getTo()));
        $newMail->setSender(Format::formatListOfNames($message->getFrom()));
        $newMail->setCopies(Format::formatListOfNames($message->getCc()));
        $newMail->setBlindCopies(Format::formatListOfNames($message->getBcc()));
        // Take care of attachments
        $this->saveAttachments($message, $newMail);
        // Add the object itself
        $newMail->setMail(serialize($message));
        // Add to the repository and persist
        $this->mailRepository->add($newMail);
        $this->persistenceManager->persistAll();

        // Return every recipient as "delivered"
        $count = count((array)$message->getTo()) + count((array)$message->getCc()) + count((array)$message->getBcc());
        return $count;
    }

    /**
     * Registers a plugin in the Transport.
     *
     * Not used.
     *
     * @param \Swift_Events_EventListener $plugin
     */
    public function registerPlugin(\Swift_Events_EventListener $plugin)
    {
        // TODO: Implement registerPlugin() method.
    }

    /**
     * Defines the storage pid for mail objects
     *
     * @return int
     */
    protected function getStoragePage()
    {
        // Default is the configured storage pid (or 0)
        $storagePid = (array_key_exists('storagePid', $this->configuration)) ? $this->configuration['storagePid'] : 0;
        // In the FE context, use the current page, unless it should be overridden by the default storage pid
        if (isset($GLOBALS['TSFE']) && empty($this->configuration['storagePidOverride'])) {
            $storagePid = $GLOBALS['TSFE']->id;
        }
        return $storagePid;
    }

    /**
     * Gathers all attachments from the message and stores them for later use
     *
     * This is necessary because attachments will generally be stored as temporary files,
     * which will not exist anymore when the Scheduler task will attempt to send the original
     * messages. Thus we store the attachments here and restore them upon sending.
     *
     * @param MailMessage $message The current message
     * @param Mail $mail The mail object for storage
     * @return void
     */
    protected function saveAttachments(MailMessage $message, Mail $mail)
    {
        $attachments = array();
        // Loop on all children (if any)
        $children = $message->getChildren();
        foreach ($children as $aChild) {
            // If child is an attachment, read its content and store it in a specific location
            if ($aChild instanceof \Swift_Mime_Attachment) {
                $temporaryFilename = PATH_site . 'uploads/tx_batchmailer/' . uniqid('txbm', true) . '-' . $aChild->getFilename();
                $fp = fopen($temporaryFilename, 'w');
                if ($fp) {
                    fwrite($fp, $aChild->getBody());
                    fclose($fp);
                }
                // TODO: report write errors somewhere
                $attachments[] = $temporaryFilename;
                // Delete the current attachment
                $message->detach($aChild);
            }
        }
        // Add all attachment references as a comma-separated list of file names
        if (count($attachments) > 0) {
            $mail->setAttachments(
                    implode(',', $attachments)
            );
        }
    }
}
