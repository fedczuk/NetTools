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
 * NetCalculations Tools - MY_Loader Class
 *
 * Rozszerzenie klasy CI_Loader frameworka CodeIgniter
 * o dodatkowe możliwości dołączania plików PHP.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class MY_Loader extends CI_Loader {
	
	function MY_Loader() {
		parent::CI_Loader();
	}
	
	function file($path) {
		if (file_exists(APPPATH.$path.EXT)) {		
			include_once(APPPATH.$path.EXT);
			return TRUE;
		}
		
		return FALSE;
	}
}
