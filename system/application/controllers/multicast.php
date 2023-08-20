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
 * NetCalculations Tools - Multicast Controller Class
 *
 * Na podstawie adresu IP klasy D (multicast) 
 * wylicza multicastowy adres MAC.
 * 
 * @package		NetCalculations Tools
 * @subpackage	Controllers
 * @category	Controllers
 * @author		SFinX
 */

class MulticastController extends MY_Controller {
	
	function MulticastController() {
		parent::MY_Controller();
	}
	
	function index() {
		$data = array();
		
		if (isset($_POST['values']))
			$data = $this->_results();
		
		$data['title'] = 'Kalkulator adresów sprzętowych multicast';
		$data['content'] = $this->load->view('multicast', '', TRUE);
		$this->load->view('layout', $data);
	}
	
	function _form_validation() {
		$this->form_validation->set_rules('values', 'Adresy IP', 'trim|required|valid_ips');
		return $this->form_validation->run();
	}
	
	function _results() {
		if (!$this->_form_validation())
			return;
		
		$this->load->library('mac');
		$this->load->library('delimiter');
		$this->load->library('table');
		
		$delimiter = $this->delimiter->get('ENTER');
		$ips = explode($delimiter, $this->input->post('values'));
		
		$result = array(array('Adres IP', 'Adres MAC'));
		foreach($ips as $ip){
			$result[] = array(
				$ip,
				$this->mac->multicast($ip),
			);
		}
		
        $data['results'] = $this->table->generate($result);
        return $data;
	}
}

?>
