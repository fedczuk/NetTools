<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * NetCalculations Tools
 *
 * Zestaw narzędzi wspomagających obliczenia dotyczące sieci.
 *
 * @package		NetCalculations Tools
 * @author		SFinX
 * @copyright	Copyright (c) 2009, SFinX
 * @license		GPLv3
 * @since		Version 0.3
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * NetCalculations Tools - Octet Class
 *
 * Zestaw statycznych funkcji operujących na oktetach adresów IP.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

define('BITS_IN_OCTET', 8);

class Octet {

	/**
	 * Dopełnienia liczbę binarną do ośmiu bitów (oktet).
	 *
	 * @param BINARY NUMBER STRING $number
	 * Liczba zapisana w systemie binarnym
	 * @param INT $format
	 * Format liczby.
	 * Aby nastąpiło dopełnienie, liczba musi być zapisana w systemie binarnym.
	 * @return BINARY NUMBER STRING
	 * Oktet dopełniony do ośmiu biów.
	 */
    function complete($number){
        $len = strlen($number);
        return str_repeat('0', BITS_IN_OCTET-$len).$number;
    }
}
?>
