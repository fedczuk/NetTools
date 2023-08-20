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
 * NetCalculations Tools - IpInfo Class
 *
 * Zestaw funkcji operujących na adresach IP.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class IpInfo {

	var $_ip;
	var $_mask;
	var $_ci;

    /**
     * @param BINARY_NUMBER $ip
     * Adres IP hosta.
     *
     * @param BINARY_NUMBER AS STRING $mask
     * Maska adresu IP hosta.
     */
    function IpInfo(){
        $this->_ci =& get_instance();
		$this->_ci->load->file('libraries/Address');	
		$this->_ci->load->file('libraries/Mask');
    }
	
	/**
	 * Ustawia aktywny adres hosta.
	 * 
	 * @param STRING
	 * Adres hosta zapisany: 'ip/maska'.
	 */ 
	function set($ip){
		$addresses = explode('/', $ip);
		$this->_ip = new Address(trim($addresses[0]));
		$this->_mask = new Mask(trim($addresses[1]));
	}

    /**
     * @return BINARY_NUMBER
     * Adres IP hosta.
     */
    function ip(){
        return $this->_ip;
    }

    /**
     * @return BINARY_NUMBER
     * Maska hosta.
     */
    function mask(){
        return $this->_mask;
    }

    /**
     * @return BINARY_NUMBER
     * Adres IP podsieci hosta.
     */
    function subnet(){
        $address = Address::_AND($this->ip()->get_octets(), $this->mask()->get_octets());
        $subnet = new Address($address);
        return $subnet;
    }

    /**
     * @return BINARY_NUMBER
     * Adres rozgłoszeniowy podsieci.
     */
    function brodcast(){
        $not_mask = Address::_NOT($this->mask()->get_octets());
        $address = Address::_OR($this->ip()->get_octets(), $not_mask);
        $brodcast = new Address($address);
        return $brodcast;
    }

    /**
     * @return BINARY_NUMBER
     * Adres IP pierwszego hosta w sieci.
     */
    function first_host(){
        $subnet = $this->subnet();
        $subnet = $subnet->get_octets();
        $subnet[3] += 1;
        $first_host = new Address($subnet);
        return $first_host;
    }

    /**
     * @return BINARY_NUMBER
     * Adres IP ostatniego hosta w sieci.
     */
    function last_host(){
        $brodcast = $this->brodcast();
        $brodcast = $brodcast->get_octets();
        $brodcast[3] -= 1;
        $last_host = new Address($brodcast);
        return $last_host;
    }

    /**
     * @return INT
     * Liczba hostów w sieci.
     */
    function number_of_hosts(){
        return $this->mask()->get_number_of_hosts();
    }

    /**
     * @return INT
     * Liczba podsieci, które można zbudować w oparciu o maskę.
     */
    function number_of_subnets(){
        $bin_mask = $this->mask()->get_bin();
        $bin_mask = str_replace('.', '', $bin_mask);
        $subnet_bits = str_replace('0', '', $bin_mask);
        $num_of_subnet_bits = strlen($subnet_bits) % BITS_IN_OCTET;
        return pow(2, $num_of_subnet_bits);
    }
}

?>
