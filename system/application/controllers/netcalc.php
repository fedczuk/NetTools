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
 * NetCalculations Tools - Modulation Controller Class
 *
 * Wylicza podstawowe parametry podsieci (adres podsieci, 
 * liczba hostów, broadcast) bazując na adresie sieci
 * oraz liczbie komputerów w każdej z podsieci.
 * 
 * @package		NetCalculations Tools
 * @subpackage	Controllers
 * @category	Controllers
 * @author		SFinX
 */

class NetCalcController extends MY_Controller {
	
	function NetCalcController() {
		parent::MY_Controller();
	}
	
	function index() {
		$data = array();
		
		if (isset($_POST['network']))
			$data = $this->_results();
			
		$data['title'] =  'Kalkulator sieci';
        $data['content'] = $this->load->view('netcalc/form', '', TRUE);
        $this->load->view('layout', $data);
	}
	
	function _form_validation() {
		$this->form_validation->set_rules('network', 'Adres podsieci', 'trim|required|valid_ip_mask');
		$this->form_validation->set_rules('values', 'Liczba hostów w każdej podsieci', 'trim|required|valid_numbers[10]');
		
		return $this->form_validation->run();
	}
	
	function _calculate($address, $hosts) {
		$this->load->library('address');
		$this->load->library('mask');
		
		$subnet = explode('/', $address);
		$this->mask->set($subnet[1]);
		$this->address->set($subnet[0]);
		
		$result['params']['subnet'] = $this->address->get();
		$result['params']['mask'] = $this->mask->get();
		$result['params']['cidr'] = $this->mask->get_cidr();
		$result['params']['addresses'] = $this->mask->get_number_of_hosts();
		
		$host_sum = 0;
		$host_max = $result['params']['addresses'];
		$overflowed = FALSE;
		
		foreach($hosts as $host) {
			$ofh = FALSE; //overflow help
			
			$cidr = $this->mask->calculate_mask($host);
			$this->mask->set($cidr);
			
			$addresses_count = $this->mask->get_number_of_hosts();
			$host_sum += $addresses_count;
			
			if (!$overflowed && $host_sum > $host_max)
				$overflowed = $ofh = TRUE;
			
			$result['results'][] = array(
				'hosts' => $host,
				'subnet' => $this->address->get(),
				'mask' => $this->mask->get(),
				'cidr' => $this->mask->get_cidr(),
				'addresses' => $addresses_count,
				'brodcast' => implode('.', $this->address->next($addresses_count-1)),
				'overflow' => $ofh,
			);
			
			$next_subnet = $this->address->next($addresses_count);
			$this->address->set($next_subnet);
		}
		
		return $result;
	}
	
	function _results() {
		if (!$this->_form_validation())
			return;
		
		$this->load->library('delimiter');
		$this->load->helper('html');
		
		$address = $this->input->post('network');
		$delimiter = $this->delimiter->get('ENTER');
		$hosts = explode($delimiter, $this->input->post('values'));
		
		$result = $this->_calculate($address, $hosts);
		
		$data['results'] = $this->load->view('netcalc/results', $result, TRUE);
		return $data;
	}
}
