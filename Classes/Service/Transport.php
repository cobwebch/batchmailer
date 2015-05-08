<?php
namespace Cobweb\Batchmailer\Service;

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

use Cobweb\Batchmailer\Domain\Model\Mail;
use Cobweb\Batchmailer\Utility\Format;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Mail Transport which stores all mails in a database table, to be sent later by a Scheduler task.
 *
 * @author Francois Suter <typo3@cobweb.ch>
 * @package batchmailer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Transport implements \Swift_Transport {
	/**
	 * @var \Cobweb\Batchmailer\Domain\Repository\MailRepository
	 */
	protected $mailRepository;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	protected $objectManager;

	/**
	 * Instance of the persistence manager
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
	 */
	protected $persistenceManager;

	/**
	 * @var array
	 */
	protected $configuration = array();

	public function __construct($settings) {
		// Initialize objects manually, as the full Extbase context is not loaded and we cannot rely
		// on dependency injection at this point
		$this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->mailRepository = $this->objectManager->get('Cobweb\\Batchmailer\\Domain\\Repository\\MailRepository');
		$this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
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
	public function isStarted() {
		return FALSE;
	}

	/**
	 * Starts this Transport mechanism.
	 *
	 * Not used.
	 */
	public function start() {
		// TODO: Implement start() method.
	}

	/**
	 * Stops this Transport mechanism.
	 *
	 * Not used.
	 */
	public function stop() {
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
	public function send(\Swift_Mime_Message $message, &$failedRecipients = null) {
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
	}

	/**
	 * Registers a plugin in the Transport.
	 *
	 * Not used.
	 *
	 * @param \Swift_Events_EventListener $plugin
	 */
	public function registerPlugin(\Swift_Events_EventListener $plugin) {
		// TODO: Implement registerPlugin() method.
	}

	/**
	 * Defines the storage pid for mail objects
	 *
	 * @return int
	 */
	protected function getStoragePage() {
		// Default is the configured storage pid (or 0)
		$storagePid = (isset($this->configuration['storagePid'])) ? $this->configuration['storagePid'] : 0;
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
	 * @param \TYPO3\CMS\Core\Mail\MailMessage $message The current message
	 * @param Mail $mail The mail object for storage
	 * @return void
	 */
	protected function saveAttachments(\TYPO3\CMS\Core\Mail\MailMessage $message, Mail $mail) {
		$attachments = array();
		// Loop on all children (if any)
		$children = $message->getChildren();
		foreach ($children as $aChild) {
			// If child is an attachment, read its content and store it in a specific location
			if ($aChild instanceof \Swift_Mime_Attachment) {
				$temporaryFilename = PATH_site . 'uploads/tx_batchmailer/' . uniqid() . '-' . $aChild->getFilename();
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
