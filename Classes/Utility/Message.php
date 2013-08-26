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
 * Dummy message class.
 *
 * This is needed to use in the Mail model, as Extbase expects variables types to be
 * either some simple or standard types, or to start with "Tx_". This makes it impossible
 * to use "t3lib_mail_Message" or "Swift_Message" as a variable type.
 *
 * @author Francois Suter <typo3@cobweb.ch>
 * @package batchmailer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * $Id: Message.php 72684 2013-03-12 13:47:59Z francois $
 */
class Tx_Batchmailer_Utility_Message extends t3lib_mail_Message {
}
?>