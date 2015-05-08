<?php
namespace Cobweb\Batchmailer\Domain\Model;

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
 * Model for the Mail object
 *
 * @package batchmailer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Mail extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Recipients of the mail
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $recipients = '';

	/**
	 * Persons cc'ed in the mail
	 *
	 * @var string
	 */
	protected $copies = '';

	/**
	 * Persons bcc'ed in the mail
	 *
	 * @var string
	 */
	protected $blindCopies = '';

	/**
	 * Person sending the mail (from field)
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $sender = '';

	/**
	 * Subject of the mail
	 *
	 * @var string
	 */
	protected $subject = '';

	/**
	 * Content of the mail
	 *
	 * @var string
	 */
	protected $body;

	/**
	 * The mail object itself, serialized
	 *
	 * @var string
	 */
	protected $mail;

	/**
	 * Comma-separated list of file names, corresponding to the mail's attachments
	 *
	 * @var string
	 */
	protected $attachments;

	/**
	 * TRUE if the mail has been sent
	 *
	 * @var boolean
	 */
	protected $sent = FALSE;

	/**
	 * Result status of the mail (OK = 6, warning = 4, error = 3)
	 *
	 * NOTE: the values correspond to \TYPO3\CMS\Core\Log\LogLevel::INFO and \TYPO3\CMS\Core\Log\LogLevel::ERROR
	 * respectively, taken from TYPO3 CMS 6.0
	 *
	 * @var integer
	 */
	protected $sentStatus = 0;

	/**
	 * Error message, if sending the mail failed
	 *
	 * @var string
	 */
	protected $sentErrorMessage;

	/**
	 * Date at which the mail was sent
	 *
	 * @var \DateTime
	 * @validate DateTime
	 */
	protected $sentDate;

	/**
	 * Number of times the mailer has tried to send this mail
	 *
	 * @var integer
	 */
	protected $sentTries = 0;

	/**
	 * Returns the recipients
	 *
	 * @return string $recipients
	 */
	public function getRecipients() {
		return $this->recipients;
	}

	/**
	 * Sets the recipients
	 *
	 * @param string $recipients
	 * @throws \InvalidArgumentException
	 * @return void
	 */
	public function setRecipients($recipients) {
		if (empty($recipients)) {
			throw new \InvalidArgumentException('Recipients cannot be empty', 1373191132);
		}
		$this->recipients = $recipients;
	}

	/**
	 * Returns the copies
	 *
	 * @return string $copies
	 */
	public function getCopies() {
		return $this->copies;
	}

	/**
	 * Sets the copies
	 *
	 * @param string $copies
	 * @return void
	 */
	public function setCopies($copies) {
		$this->copies = $copies;
	}

	/**
	 * Returns the blindCopies
	 *
	 * @return string $blindCopies
	 */
	public function getBlindCopies() {
		return $this->blindCopies;
	}

	/**
	 * Sets the blindCopies
	 *
	 * @param string $blindCopies
	 * @return void
	 */
	public function setBlindCopies($blindCopies) {
		$this->blindCopies = $blindCopies;
	}

	/**
	 * Returns the sender
	 *
	 * @return string $sender
	 */
	public function getSender() {
		return $this->sender;
	}

	/**
	 * Sets the sender
	 *
	 * @param string $sender
	 * @throws \InvalidArgumentException
	 * @return void
	 */
	public function setSender($sender) {
		if (empty($sender)) {
			throw new \InvalidArgumentException('Sender cannot be empty', 1373191316);
		}
		$this->sender = $sender;
	}

	/**
	 * Returns the subject
	 *
	 * @return string $subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * Sets the subject
	 *
	 * @param string $subject
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Returns the body
	 *
	 * @return string $body
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * Sets the body
	 *
	 * @param string $body
	 * @return void
	 */
	public function setBody($body) {
		$this->body = $body;
	}

	/**
	 * Returns the mail
	 *
	 * @return string $mail
	 */
	public function getMail() {
		return $this->mail;
	}

	/**
	 * Sets the mail
	 *
	 * @param string $mail
	 * @return void
	 */
	public function setMail($mail) {
		$this->mail = $mail;
	}

	/**
	 * Returns the sent flag
	 *
	 * @return boolean
	 */
	public function getSent() {
		return $this->sent;
	}

	/**
	 * Sets the sent flag
	 *
	 * @param boolean $sent
	 * @return void
	 */
	public function setSent($sent) {
		$this->sent = $sent;
	}

	/**
	 * Returns the sent status
	 *
	 * @return boolean
	 */
	public function getSentStatus() {
		return $this->sentStatus;
	}

	/**
	 * Sets the sent status (OK = 6, warning = 4, error = 3)
	 *
	 * @param integer $sentStatus
	 * @return void
	 */
	public function setSentStatus($sentStatus) {
		$this->sentStatus = $sentStatus;
	}

	/**
	 * Returns the error message
	 *
	 * @return boolean
	 */
	public function getSentErrorMessage() {
		return $this->sentErrorMessage;
	}

	/**
	 * Sets the error message
	 *
	 * @param string $sentErrorMessage
	 * @return void
	 */
	public function setSentErrorMessage($sentErrorMessage) {
		$this->sentErrorMessage = $sentErrorMessage;
	}

	/**
	 * Returns the sent date
	 *
	 * @return \DateTime
	 */
	public function getSentDate() {
		return $this->sentDate;
	}

	/**
	 * Sets the sent date
	 *
	 * @param \DateTime $sentDate
	 * @return void
	 */
	public function setSentDate(\DateTime $sentDate) {
		$this->sentDate = $sentDate;
	}

	/**
	 * Sets the list of attachments
	 *
	 * @param string $attachments
	 */
	public function setAttachments($attachments) {
		$this->attachments = $attachments;
	}

	/**
	 * Gets the list of attachments
	 *
	 * @return string
	 */
	public function getAttachments() {
		return $this->attachments;
	}

	/**
	 * @param int $sentTries
	 * @throws \InvalidArgumentException
	 */
	public function setSentTries($sentTries) {
		$sentTries = intval($sentTries);
		if ($sentTries < 0) {
			throw new \InvalidArgumentException('Sender cannot be empty', 1373191727);
		}
		$this->sentTries = $sentTries;
	}

	/**
	 * @return int
	 */
	public function getSentTries() {
		return $this->sentTries;
	}

}
