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
 * NetCalculations Tools - Mask Class
 *
 * Funkcje operujace na masce adresu IP.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

include_once(APPPATH.'libraries/Address'.EXT);

/**
 * Liczba bitów adresu IP w wersji 4.
 */ 
define('IP4_NUM_OF_BITS', 32);

class Mask extends Address {

    function Mask($mask = '') {
		parent::Address();
		if (!empty($mask))
			$this->set($mask);
    }

	/**
	 * Ustawia aktywny adres maski.
	 */ 
	function set($mask) {
		if ($this->is_cidr($mask))
            $mask = $this->_to_address($mask);
        parent::set($mask);
	}
	
    /**
     * Sprawdza, czy podana maska jest zapisana w notacji CIDR.
     *
     * @param STRING/NUMBER $mask
     * Maska sieciowa.
     *
     * @return BOOL
     * TRUE gdy CIDR, inaczaczej false.
     */
    function is_cidr($mask) {
        if (is_numeric($mask) && $mask >= 0 && $mask <= 32)
            return TRUE;

        return FALSE;
    }

    /**
     * Konwertuje maskę zapisaną w notacji CIDR na postać adresu sieciowego.
     *
     * @param NUMBER $cidr
     * Maska w notacji CIDR.
     *
     * @return ARRAY
     * Oktety adresu maski.
     */
    function _to_address($cidr) {
        $mask = str_repeat('1', $cidr).str_repeat('0', IP4_NUM_OF_BITS-$cidr);
        $octets = str_split($mask, BITS_IN_OCTET);
        $len = count($octets);
        for($i = 0; $i < $len; $i++) {
            $octets[$i] = bindec($octets[$i]);
        }
        return $octets;
    }

    /**
     * Maska adresu zapisana w notacji CIDR.
     *
     * @return NUMBER
     * Maska w postaci CIDR.
     */
    function get_cidr() {
        $octets = $this->get_bin_octets();
        $bin_mask = implode('', $octets);
        $cidr = str_replace('0', '', $bin_mask);
        return strlen($cidr);
    }

	//TODO: zmienić nazwę na bardziej zrozumiałą
    function get_number_of_hosts(){
        $bin_mask = $this->get_bin();
        $bin_mask = str_replace('.', '', $bin_mask);
        $host_bits = str_replace('1', '', $bin_mask);
        return pow(2, strlen($host_bits))-2;
    }

	/* ----------------- */
	/* FUNKCJE STATYCZNE */
	/* ----------------- */

    /**
     * Wylicza maskę dla podanej liczby hostów.
     *
     * @param INT $hosts
     * Liczba hostów w podsieci.
     * @return INT
     * Maska zapisana w konwencji CIDR.
     */
    function calculate_mask($hosts){
        $host_bits = log($hosts, 2);
        if (is_float($host_bits))
            $host_bits = (int)$host_bits + 1;

		$mask = IP4_NUM_OF_BITS-$host_bits;
		if (pow(2, $host_bits)-2 < $hosts)
			$mask -= 1;
        
		return $mask;
    }
}

?>
