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
 * NetCalculations Tools - Numbers Class
 *
 * Funkcje operujace na liczbach w różnych systemach liczbowych.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class Numbers {

    function convert($numbers, $base, $to) {
        if (empty($numbers))
            return NULL;

        $result = NULL;
        if (is_array($numbers)) {
            foreach($numbers as $key => $value)
                $result[$key] = base_convert($value, $base, $to);
        }
        else {
            $result = base_convert($numbers, $base, $to);
        }
        
        return $result;
    }

	/**
	 * Udostępnia cyfry i znaki, z których 
	 * w danym systemie można tworzyć liczby.
	 * 
	 * @param INT $type
	 * System liczbowy np. dziesiętny = 10
	 */ 
    function get_numerals($type) {
        $end = $type;
        if ($type > 10)
            $end = 10;

        $avaliable = range(0, $end-1);
        for($i = 10; $i < $type; $i++)
            $avaliable[$i] = base_convert($i, 10, $type);

        return $avaliable;
    }
}

?>
