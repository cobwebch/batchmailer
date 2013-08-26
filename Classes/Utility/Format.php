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
 * Formatting utilities.
 *
 * @author Francois Suter <typo3@cobweb.ch>
 * @package batchmailer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * $Id: Format.php 72684 2013-03-12 13:47:59Z francois $
 */
class Tx_Batchmailer_Utility_Format {
	/**
	 * Formats a list of SwiftMail people (array with e-mail addresses as keys and names as values)
	 *
	 * @param array $array List of people
	 * @return string
	 */
	public static function formatListOfNames($array) {
		$list = array();
		foreach ($array as $key => $value) {
			$list[] = $value . ' <' . $key . '>';
		}
		return implode("\n", $list);
	}
}
?>