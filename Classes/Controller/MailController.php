<?php
namespace Cobweb\Batchmailer\Controller;

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
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for a possible BE module. Not used yet.
 *
 * @package batchmailer
 */
class MailController extends ActionController
{

    /**
     * mailRepository
     *
     * @var MailRepository
     */
    protected $mailRepository;

    /**
     * injectMailRepository
     *
     * @param MailRepository $mailRepository
     * @return void
     */
    public function injectMailRepository(MailRepository $mailRepository)
    {
        $this->mailRepository = $mailRepository;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $mails = $this->mailRepository->findAll();
        $this->view->assign('mails', $mails);
    }

    /**
     * action show
     *
     * @param Mail $mail
     * @return void
     */
    public function showAction(Mail $mail)
    {
        $this->view->assign('mail', $mail);
    }

    /**
     * action delete
     *
     * @param Mail $mail
     * @return void
     */
    public function deleteAction(Mail $mail)
    {
        $this->mailRepository->remove($mail);
        $this->flashMessageContainer->add('Your Mail was removed.');
        $this->redirect('list');
    }

    /**
     * action reschedule
     *
     * @return void
     */
    public function rescheduleAction()
    {

    }

}