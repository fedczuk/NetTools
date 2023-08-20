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
 * NetCalculations Tools - IpCalc Controller Class
 *
 * Wylicza podstawowe parametry sieci tj. adres podsieci, broadcast,
 * liczbę hostów w podsieci, adres pierwszego i ostatniego hosta itp.
 * 
 * @package		NetCalculations Tools
 * @subpackage	Controllers
 * @category	Controllers
 * @author		SFinX
 */

class IpCalcController extends MY_Controller {
	
    function IpCalcController() {
        parent::MY_Controller();
    }
	
    function index() {
		$data = array();
		
		if (isset($_POST['values']))
			$data = $this->_results();
			
		$data['title'] = 'Kalkulator IP';
        $data['content'] = $this->load->view('ipcalc/form', '', TRUE);
        $this->load->view('layout', $data);
    }
	
	function _form_validation() {
		$this->form_validation->set_rules('values', 'Adresy IP', 'trim|required|valid_ip_mask');
		return $this->form_validation->run();
	}
	
    function _results() {
        if (!$this->_form_validation())
			return;
		
		$this->load->library('delimiter');
		$this->load->library('ipinfo');
		
		$this->load->helper('html');
		
        $delimiter = $this->delimiter->get('enter');
		$addresses = explode($delimiter, $this->input->post('values'));
		
		$result = array();
		foreach($addresses as $address) {
			$this->ipinfo->set($address);
			
			$result[] = array(
				'ip' => $this->ipinfo->ip(),
				'mask' => $this->ipinfo->mask(),
				'subnet' => $this->ipinfo->subnet(),
				'brodcast' => $this->ipinfo->brodcast(),
				'first' => $this->ipinfo->first_host(),
				'last' => $this->ipinfo->last_host(),
				'noh' => $this->ipinfo->number_of_hosts(),
				'nos' => $this->ipinfo->number_of_subnets(),
			);
		}
		
		$data['results'] = $this->load->view('ipcalc/results', array('results' => $result), TRUE);
		return $data;
    }
}

?>
