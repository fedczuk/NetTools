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
 * NetCalculations Tools - MY_Controller Class
 *
 * Rozszerzenie klasy CI_Controller frameworka CodeIgniter.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class MY_Controller extends Controller {
	
	function MY_Controller(){
		parent::Controller();
		
		$session_uri = $this->session->userdata('uri');
		
		$current_ip = $this->input->ip_address();
		$current_uri = uri_string();
		if (empty($current_uri))
			$current_uri = '/ipcalc';
		
		if ($current_uri !== $session_uri){
			$browser = $this->input->user_agent();			
			log_message('error', "$current_ip\t$current_uri\t$browser");
		}
		
		$this->session->set_userdata('uri', $current_uri);
	}
}
