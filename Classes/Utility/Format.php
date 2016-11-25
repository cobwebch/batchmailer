<?php
namespace Cobweb\Batchmailer\Utility;

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

/**
 * Formatting utilities.
 *
 * @author Francois Suter <typo3@cobweb.ch>
 * @package batchmailer
 */
class Format
{
    /**
     * Formats a list of SwiftMail people (array with e-mail addresses as keys and names as values)
     *
     * @param array $array List of people
     * @return string
     */
    public static function formatListOfNames($array)
    {
        $list = array();
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $list[] = $value . ' <' . $key . '>';
            }
        }
        return implode("\n", $list);
    }
}
