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
 * NetCalculations Tools - MAC Class
 *
 * Funkcje operujace na adresie MAC.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class Mac {
	
	var $_ci;
	
	function Mac() {
		$this->_ci =& get_instance();
		$this->_ci->load->file('libraries/Address');
	}
	
	/**
	 * Na podstawie multicastowego adresu IP
	 * wylicza multicastowy adres MAC.
	 * 
	 * @param STRING $ip
	 * Multicastowy adres IP.
	 * 
	 * @return STRING
	 * Multicastowy adres MAC, lub informacja, 
	 * że taki adres nie istnieje.
	 */ 
    function multicast($ip){
		$address = new Address($ip);
        $octets = $address->get_octets();

        if ($octets[0] < 224 || $octets[0] > 239)
            return 'Adres multicastowy MAC nie istnieje.';

        if ($octets[1] >= 128)
            $octets[1] -= 128;

        $len = count($octets);
        for($i = 1; $i < $len; $i++){
            $octets[$i] = dechex($octets[$i]);
            if (strlen($octets[$i]) == 1)
                $octets[$i] = '0'.$octets[$i];
        }
		
        array_shift($octets);
        $mac = implode('-', $octets);
        return '01-00-5E-'.strtoupper($mac);
    }
}
?>
