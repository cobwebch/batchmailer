<?php
namespace Cobweb\Batchmailer\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2014 François Suter <typo3@cobweb.ch>, Cobweb Development Sarl
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Controller for a possible BE module. Not used yet.
 *
 * @package batchmailer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class MailController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * mailRepository
	 *
	 * @var \Cobweb\Batchmailer\Domain\Repository\MailRepository
	 */
	protected $mailRepository;

	/**
	 * injectMailRepository
	 *
	 * @param \Cobweb\Batchmailer\Domain\Repository\MailRepository $mailRepository
	 * @return void
	 */
	public function injectMailRepository(\Cobweb\Batchmailer\Domain\Repository\MailRepository $mailRepository) {
		$this->mailRepository = $mailRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$mails = $this->mailRepository->findAll();
		$this->view->assign('mails', $mails);
	}

	/**
	 * action show
	 *
	 * @param \Cobweb\Batchmailer\Domain\Model\Mail $mail
	 * @return void
	 */
	public function showAction(\Cobweb\Batchmailer\Domain\Model\Mail $mail) {
		$this->view->assign('mail', $mail);
	}

	/**
	 * action delete
	 *
	 * @param \Cobweb\Batchmailer\Domain\Model\Mail $mail
	 * @return void
	 */
	public function deleteAction(\Cobweb\Batchmailer\Domain\Model\Mail $mail) {
		$this->mailRepository->remove($mail);
		$this->flashMessageContainer->add('Your Mail was removed.');
		$this->redirect('list');
	}

	/**
	 * action reschedule
	 *
	 * @return void
	 */
	public function rescheduleAction() {

	}

}