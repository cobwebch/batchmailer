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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Batchmailer_Domain_Model_Mail.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Batch Mailer
 *
 * @author François Suter <typo3@cobweb.ch>
 */
class Tx_Batchmailer_Domain_Model_MailTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Batchmailer_Domain_Model_Mail
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Batchmailer_Domain_Model_Mail();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getRecipientsInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getRecipients()
		);
	}

	/**
	 * @test
	 */
	public function setRecipientsSetsRecipients() {
		$this->fixture->setRecipients('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getRecipients()
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function setRecipientWithEmptyValueThrowsException() {
		$this->fixture->setRecipients('');
	}

	/**
	 * @test
	 */
	public function getCopiesInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getCopies()
		);
	}

	/**
	 * @test
	 */
	public function setCopiesSetsCopies() {
		$this->fixture->setCopies('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCopies()
		);
	}

	/**
	 * @test
	 */
	public function getBlindCopiesInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getCopies()
		);
	}

	/**
	 * @test
	 */
	public function setBlindCopiesSetsBlindCopies() {
		$this->fixture->setBlindCopies('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getBlindCopies()
		);
	}

	/**
	 * @test
	 */
	public function getSenderInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getCopies()
		);
	}

	/**
	 * @test
	 */
	public function setSenderSetsSender() {
		$this->fixture->setSender('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSender()
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function setSenderWithEmptyValueThrowsException() {
		$this->fixture->setSender('');
	}

	/**
	 * @test
	 */
	public function getSubjectInitiallyReturnsEmptyString() {
		$this->assertSame(
			'',
			$this->fixture->getSubject()
		);
	}

	/**
	 * @test
	 */
	public function setSubjectSetsSubject() {
		$this->fixture->setSubject('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSubject()
		);
	}

	/**
	 * @test
	 */
	public function getBodyInitiallyReturnsNull() {
		$this->assertNull(
			$this->fixture->getBody()
		);
	}

	/**
	 * @test
	 */
	public function setBodySetsBody() {
		$this->fixture->setBody('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getBody()
		);
	}

	/**
	 * @test
	 */
	public function getMailInitiallyReturnsNull() {
		$this->assertNull(
			$this->fixture->getMail()
		);
	}

	/**
	 * @test
	 */
	public function setMailSetsMail() {
		$this->fixture->setMail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMail()
		);
	}


	/**
	 * @test
	 */
	public function getSentInitiallyReturnsFalse() {
		$this->assertFalse(
			$this->fixture->getSent()
		);
	}

	/**
	 * @test
	 */
	public function setSentSetsSent() {
		$this->fixture->setSent(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getSent()
		);
	}


	/**
	 * @test
	 */
	public function getSentDateInitiallyReturnsCurrentDateObject() {
		$this->assertEquals(
			new DateTime(),
			$this->fixture->getSentDate()
		);
	}


	/**
	 * @test
	 */
	public function getSentStatusInitiallyReturnsZero() {
		$this->assertSame(
			0,
			$this->fixture->getSentStatus()
		);
	}

	/**
	 * @test
	 */
	public function setSentStatusSetsSentStatus() {
		$this->fixture->setSentStatus(6);

		$this->assertSame(
			6,
			$this->fixture->getSentStatus()
		);
	}


	/**
	 * @test
	 */
	public function getSentTriesInitiallyReturnsZero() {
		$this->assertSame(
			0,
			$this->fixture->getSentTries()
		);
	}

	/**
	 * @test
	 */
	public function setSentTriesSetsSentStatus() {
		$this->fixture->setSentTries(1);

		$this->assertSame(
			1,
			$this->fixture->getSentTries()
		);
	}

	/**
	 * @test
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function setSentTriesWithNegativeValueThrowsException() {
		$this->fixture->setSentTries(-1);
	}


	/**
	 * @test
	 */
	public function getAttachmentsInitiallyReturnsNull() {
		$this->assertNull(
			$this->fixture->getAttachments()
		);
	}

	/**
	 * @test
	 */
	public function setAttachmentsSetsAttachments() {
		$this->fixture->setAttachments('foo.png, bar.pdf');

		$this->assertSame(
			'foo.png, bar.pdf',
			$this->fixture->getAttachments()
		);
	}
}
?>