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
 * NetCalculations Tools - Delimiter Class
 *
 * Klasa umożliwia pobranie separatora, włączając separtory specjalne:
 * spacja, enter i tabulator.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class Delimiter {
	/**
	 * Przechowuje znaczniki separatorów specjalnych.
	 */ 
    var $special_delimiters = array(
        'SPACJA' => " ",
        'ENTER' => "\n",
        'TAB' => "\t",
    );

	/**
	 * Pobranie separatora.
	 * 
	 * @return STRING
	 * Separator, gotowy do użycia w funkcji explode.
	 */  
    function get($delimiter) {
        $delimiter = trim($delimiter); 
        $tmp = strtoupper($delimiter);
        if (array_key_exists($tmp, $this->special_delimiters))
            return $this->special_delimiters[$tmp];

        return $delimiter;
    }
}

?>
