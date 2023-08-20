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
 * Generuje obraz przedstawiający modulację bitów dla wybranej metody.
 * 
 * @package		NetCalculations Tools
 * @subpackage	Controllers
 * @category	Controllers
 * @author		SFinX
 */

class ModulationController extends MY_Controller {
	
	function Modulation(){
		parent::MY_Controller();
	}
	
	function index(){
		$data = array();
		
		if (isset($_POST['bits']))
			$data = $this->_results();
		
		$data['title'] =  'Modulacja';
        $data['content'] = $this->load->view('modulation', '', TRUE);
        $this->load->view('layout', $data);
	}
	
	function _form_validation(){
		$this->form_validation->set_rules('bits', 'Bity', 'trim|required|valid_numbers[2]');
        $this->form_validation->set_rules('type', 'Typ', 'trim|required');

        return $this->form_validation->run();
	}
	
	function _results(){
		if (!$this->_form_validation())
			return;
		
		$this->load->helper('html');
		
		$bits = $this->input->post('bits');
		$type = $this->input->post('type');
		
		$url = "modulation/image/$bits/$type";
		$data['results'] = img($url, TRUE);
		return $data;
	}
	
	function image($bits = '', $type = ''){
		if (empty($bits) || empty($type))
			show_404();
		
		$this->load->library('modulation');
		$this->modulation->set($bits, $type);
		$this->modulation->render();
	}
}

?>
