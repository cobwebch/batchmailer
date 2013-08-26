<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 François Suter <typo3@cobweb.ch>, Cobweb Development Sarl
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
 *
 *
 * @package batchmailer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * $Id: MailController.php 72684 2013-03-12 13:47:59Z francois $
 */
class Tx_Batchmailer_Controller_MailController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * mailRepository
	 *
	 * @var Tx_Batchmailer_Domain_Repository_MailRepository
	 */
	protected $mailRepository;

	/**
	 * injectMailRepository
	 *
	 * @param Tx_Batchmailer_Domain_Repository_MailRepository $mailRepository
	 * @return void
	 */
	public function injectMailRepository(Tx_Batchmailer_Domain_Repository_MailRepository $mailRepository) {
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
	 * @param Tx_Batchmailer_Domain_Model_Mail $mail
	 * @return void
	 */
	public function showAction(Tx_Batchmailer_Domain_Model_Mail $mail) {
		$this->view->assign('mail', $mail);
	}

	/**
	 * action delete
	 *
	 * @param Tx_Batchmailer_Domain_Model_Mail $mail
	 * @return void
	 */
	public function deleteAction(Tx_Batchmailer_Domain_Model_Mail $mail) {
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
?>