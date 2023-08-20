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
 * NetCalculations Tools - MY_Form_validation Class
 *
 * Rozszerzenie klasy CI_Form_validation frameworka CodeIgniter
 * o dodatkowe funkcje walidujące.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class MY_Form_validation extends CI_Form_validation
{
	/**
	 * Przechowuje wszystkie kombinacje 
	 * maski adresu IP w notacji kropkowo-dziesiętnej.
	 */ 
    var $masks = array(
        '0.0.0.0',
        '128.0.0.0',
        '192.0.0.0',
        '224.0.0.0',
        '240.0.0.0',
        '248.0.0.0',
        '252.0.0.0',
        '254.0.0.0',
        '255.0.0.0',
        '255.128.0.0',
        '255.192.0.0',
        '255.224.0.0',
        '255.240.0.0',
        '255.248.0.0',
        '255.252.0.0',
        '255.255.0.0',
        '255.255.128.0',
        '255.255.192.0',
        '255.255.224.0',
        '255.255.240.0',
        '255.255.248.0',
        '255.255.252.0',
        '255.255.254.0',
        '255.255.255.0',
        '255.255.255.128',
        '255.255.255.192',
        '255.255.255.224',
        '255.255.255.240',
        '255.255.255.248',
        '255.255.255.252',
        '255.255.255.254',
        '255.255.255.255',
    );

    function MY_Form_validation($rules = array())
    {
        parent::CI_Form_validation($rules);

		$msg = 'Pole %s zawiera błędne dane wejściowe.';

        $this->set_message('valid_numeral_system', 'Pole %s może zawierać wartości jedynie z przedziału 2-36.');
        $this->set_message('valid_numbers', $msg);
		$this->set_message('valid_mask', 'Pole %s zawiera nieprawidlową maskę.');
        $this->set_message('valid_ip_mask', $msg);
		$this->set_message('valid_ips', $msg);
    }

    function valid_numeral_system($str){
		if ($this->is_natural_no_zero($str))
			if ((int)$str >= 2 && (int)$str <= 36)
				return TRUE;

        return FALSE;
    }

    function valid_numbers($str, $val){
		$type = $val;
		if ($this->CI->input->post($val) != FALSE)
			$type = $this->CI->input->post($val);
		
        $this->CI->load->library('numbers');
        $numerals = implode($this->CI->numbers->get_numerals($type));

        if (preg_match_all('/['.$numerals.'\s]/i', $str, $matches) == strlen($str))
            return TRUE;

        return FALSE;
    }
	
	function _get_ips($str){
		$this->CI->load->library('delimiter');
		$delimiter = $this->CI->delimiter->get('ENTER');
		
		return explode($delimiter, $str);
	}
	
	function valid_mask($str){
		if ($this->is_numeric($str)){
			if($str >= 0 && $str <= 32)
				return TRUE;
		}
		else
		if ($this->CI->input->valid_ip($str)){
			if (array_search($str, $this->masks) !== FALSE)
				return TRUE;
		}
		return FALSE;
	}

    function valid_ip_mask($str){
        $ips = $this->_get_ips($str);
        foreach($ips as $ip){
            $host = explode('/', $ip);

			if (count($host) != 2)
				return FALSE;
				
			if (!$this->CI->input->valid_ip($host[0]) || !$this->valid_mask($host[1]))
				return FALSE;
        }
        return TRUE;
    }
	
	function valid_ips($str){
		$ips = $this->_get_ips($str);
		foreach($ips as $ip)
			if (!$this->CI->input->valid_ip($ip))
				return FALSE;
				
		return TRUE;
	}
}

?>
