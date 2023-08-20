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
 * Konwertuje liczby między systemami liczbowymi.
 * 
 * @package		NetCalculations Tools
 * @subpackage	Controllers
 * @category	Controllers
 * @author		SFinX
 */

class NumbersController extends MY_Controller {
    
	function NumbersController() {
        parent::MY_Controller();
    }

    function index() {
		$data = array();
		
		if (isset($_POST['values']))
			$data = $this->_results();
		
        $data['title'] =  'Konwerter liczb';
        $data['content'] = $this->load->view('numbers', '', TRUE);
        $this->load->view('layout', $data);
    }
	
	function _form_validation() {
		$this->form_validation->set_rules('values', 'Liczby', 'trim|required|valid_numbers[base]');
        $this->form_validation->set_rules('base', 'Typ bazowy', 'trim|required|numeric|valid_numeral_system');
        $this->form_validation->set_rules('to', 'Typ docelowy', 'trim|required|numeric|valid_numeral_system');
		
		return $this->form_validation->run();
	}

    function _results() {
        if (!$this->_form_validation())
			return;

		$this->load->library('delimiter');
		$this->load->library('numbers');
		$this->load->library('table');
		
        $values = $this->input->post('values');
        $base = $this->input->post('base');
        $to = $this->input->post('to');

        $delimiter = $this->delimiter->get('enter');
        $numbers = explode($delimiter, $values);
        $result = $this->numbers->convert($numbers, $base, $to);
        
        $this->table->set_heading('Baza', 'Razultat');
        foreach($numbers as $key => $value)
            $this->table->add_row($numbers[$key], $result[$key]);

        $data['results'] = $this->table->generate();
		return $data;
    }
}

?>
