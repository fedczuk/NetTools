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
 * NetCalculations Tools - Ascii Class
 *
 * Umożliwia pobranie znaku ascii oraz
 * konwersję ciągu znaków na tablicę liczb dziesiętnych.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class Ascii 
{
	/**
	 * Zawiera opisy słowne znaków niedrukowanych.
	 */ 
    var $ascii_table = array(
        'null',
		'start of heading',
		'start of text',
		'end of text',
		'end of transmission',
		'enquiry',
		'acknowledge',
		'bell',
		'backspace',
		'horizontal tab',
		'new line',
		'vertical tab',
		'new page',
		'carriage return',
		'shift out',
		'shift in',
		'data link escape',
		'device control 1',
		'device control 2',
		'device control 3',
		'device control 4',
		'negative acknowledge',
		'synchronous idle',
		'end of trans. block',
		'cancel',
		'end of medium',
		'substitute',
		'escape',
		'file separator',
		'group separator',
		'record separator',
		'unit separator',
		' (space)',
        127 => 'delete',
    );

	/**
	 * Pobiera znak o danym numerze.
	 * 
	 * @param INT
	 * Numer znaku.
	 * 
	 * @return CHAR
	 * Znak lub słowny opis znaku np. niedrukowanego.
	 */ 
    function get_char($number)
    {
        if (array_key_exists($number, $this->ascii_table))
            return $this->ascii_table[$number];
        else
            return chr($number);
    }

	/**
	 * Konwertuje znaki na ich reprezentacje liczbowe.
	 * 
	 * @param STRING
	 * Ciąg znaków do konwersji.
	 * 
	 * @return ARRAY
	 * Reprezentacja liczbowa znaków w systemie dziesiętnym.
	 */
    function ascii_to_dec($chars)
    {
        $result = array();

        $len = count($chars);
        for($i = 0; $i < $len; $i++)
            $result[$i] = ord($chars[$i]);

        return $result;
    }
}

?>
