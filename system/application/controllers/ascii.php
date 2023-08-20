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
 * NetCalculations Tools - Ascii Controller Class
 *
 * Umożliwia konwersję liczb na litery i odwrotnie,
 * bazujac na zbiorze ASCII.
 * 
 * @package		NetCalculations Tools
 * @subpackage	Controllers
 * @category	Controllers
 * @author		SFinX
 */

class AsciiController extends MY_Controller {
    
	function AsciiController() {
        parent::MY_Controller();
    }

	/**
	 * Wyświetla główny layout, formularz 
	 * oraz jeśli istnieje - wynik.
	 */ 
    function index() {
		$data = array();
		
		if (isset($_POST['values']))
			$data = $this->_results();
		
        $data['title'] =  'Konwerter kodów ASCII';
        $data['content'] = $this->load->view('ascii', '', TRUE);
        $this->load->view('layout', $data);
    }
	
	/**
	 * Walidacja poprawności danych formluarza.
	 * 
	 * @return BOOL
	 * TRUE gdy dane są poprawne, inaczej - FALSE.
	 */ 
	function _form_validation() {
		$this->form_validation->set_rules('values', 'Znaki', 'trim|required');
        $this->form_validation->set_rules('type', 'Typ', 'trim|valid_numeral_system');

        return $this->form_validation->run();
	}
	
	/**
	 * Oblicza lub generuje wynik dla podanych
	 * w formularzu parametrów.
	 * 
	 * @return ARRAY
	 * Wynik gotowy do wyświetlenia.
	 */ 
    function _results() {
        if (!$this->_form_validation())
            return;
        
		$this->load->library('ascii');
		$this->load->library('delimiter');
		$this->load->library('table');
		
        $values = $this->input->post('values');
        $type = $this->input->post('type');   
        $delimiter = $this->delimiter->get($this->input->post('delimiter'));

        if (empty($delimiter))
            $chars = str_split($values);
        else
            $chars = explode($delimiter, $values);

        if (empty($type)) {
            $chars = $this->ascii->ascii_to_dec($chars);
            $type = 10;
        }

        if ($type != 10) {
            $this->load->library('numbers');
            $chars = $this->numbers->convert($chars, $type, 10);
        }

		$result = array(
            'char' => array('Char:'),
            'dec' => array('Dec:'),
            'bin' => array('Bin:'),
            'hex' => array('Hex:'),
        );

        $len = count($chars);
        for($i = 1; $i <= $len; $i++) {
            $dec = $chars[$i-1];
            $result['char'][$i] = $this->ascii->get_char($dec);
            $result['dec'][$i] = $dec;
            $result['bin'][$i] = decbin($dec);
            $result['hex'][$i] = strtoupper(dechex($dec));
        }

        $data['results'] = $this->table->generate($result);
        return $data;
    }
}

?>
