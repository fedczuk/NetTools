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

define('IP4_DELIMITER', '.');

/**
 * NetCalculations Tools - Address Class
 *
 * Klasa opisująca adres sieciowy oraz operacje z nim związane.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class Address {
    /**
     * Przechowuje tablicę oktetów adresu w postaci dziesiętnej.
     *
     * @var ARRAY
     */
    var $_octets;
	var $_ci;
	
    function Address($address = '') {
		$this->_ci =& get_instance();
        $this->_ci->load->library('octet');
		if (!empty($address))
			$this->set($address);
    }
	
	/**
	 * Ustawia aktywny adres sieciowy.
	 */ 
	function set($address) {
		if (is_array($address))
            $this->_octets = $address;
        else
            $this->_octets = explode(IP4_DELIMITER, $address);
	}

    /**
     * Udostępnia przechowywany adres sieciowy.
     *
     * @return STRING
     */
    function get() {
        return implode(IP4_DELIMITER, $this->_octets);
    }

    /**
     * Udostępnia przechowywany adres sieciowy w formie binarnej.
     *
     * @return STRING
     */
    function get_bin() {
        $result = $this->get_bin_octets();
        return implode(IP4_DELIMITER, $result);
    }

    /**
     * Tablica oktetów adresu w posiaci dziesiętnej.
     *
     * @return ARRAY
     */
    function get_octets() {
        return $this->_octets;
    }

    /**
     * Tablica oktetów adresu w postaci binarnej.
     *
     * @return ARRAY
     */
    function get_bin_octets() {
        $result = $this->_octets;
        $len = count($result);
        for($i = 0; $i < $len; $i++) {
            $result[$i] = $this->_ci->octet->complete(decbin($result[$i]));
        }
        return $result;
    }

	/**
	 * Wylicza adres sieciowy 'oddalony' o określoną liczbę hostów.
	 * 
	 * @param INT $hosts
	 * Liczba hostów dzieląca adresy.
	 * 
	 * @return ARRAY
	 * Nowy adres sieciowy.
	 */ 
    function next($hosts){
        $octets = $this->get_octets();
        $count = count($octets);
        $octets[3] += $hosts;
		for($i = 3; $octets[$i] >= 256 && $i != 0; $i--){
			$n = $octets[$i]/256;
			$octets[$i-1] += (int)$n;
            $octets[$i] -= 256*(int)$n;
		}
        return $octets;
    }

	/* ----------------- */
	/* FUNKCJE STATYCZNE */
	/* ----------------- */
	
    /**
     * Logiczna operacja AND na adresach sieciowych.
     *
     * @param ARRAY/STRING $address1
     * Adres pierwszy.
     *
     * @param ARRAY/STRING $address2
     * Adres drugi.
     *
     * @return ARRAY
     * Tablica zawierająca kolejne oktety wynikowego adresu.
     */
    function _AND($address1, $address2) {
        if (!is_array($address1))
            $address1 = explode(IP4_DELIMITER, $address1);

        if (!is_array($address2))
            $address2 = explode(IP4_DELIMITER, $address2);

        $len = count($address1);
        if ($len != count($address2))
            return NULL;

        $result = array();
        for($i = 0; $i < $len; $i++) {
            $result[$i] = (int)$address1[$i] & (int)$address2[$i];
        }
        return $result;
    }

    /**
     * Logiczna operacja OR na adresach sieciowych.
     *
     * @param ARRAY/STRING $address1
     * Adres pierwszy.
     *
     * @param ARRAY/STRING $address2
     * Adres drugi.
     *
     * @return ARRAY
     * Tablica zawierająca oktety wynikowego adresu.
     */
    function _OR($address1, $address2) {
        if (!is_array($address1))
            $address1 = explode(IP4_DELIMITER, $address1);

        if (!is_array($address2))
            $address2 = explode(IP4_DELIMITER, $address2);

        $len = count($address1);
        if ($len != count($address2))
            return NULL;

        $result = array();
        for($i = 0; $i < $len; $i++) {
            $result[$i] = (int)$address1[$i] | (int)$address2[$i];
        }
        return $result;
    }

    /**
     * Logiczna operacja NOT na adresie sieciowych.
     *
     * @param ARRAY/STRING $address
     * Adres sieciowy.
     *
     * @return ARRAY
     * Tablica zawierająca oktety wynikowego adresu.
     */
    function _NOT($address) {
        if (!is_array($address))
            $address = explode(IP4_DELIMITER, $address);

        $len = count($address);
        $result = array();
        for($i = 0; $i < $len; $i++){
            $tmp = ~(int)$address[$i];
            $result[$i] = 256 + $tmp;
        }
        return $result;
    }
}

?>
