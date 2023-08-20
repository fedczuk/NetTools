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

	echo form_open(uri_string());
	echo form_label('Adresy podsieci:', 'network');
	echo form_input('network', $this->input->post('network'));
	echo small('IP/MASKA');
	echo form_label('Liczba hostów w każdej podsieci:');
	echo form_textarea('values', $this->input->post('values'));
	echo form_submit('submit', 'Wylicz');
	echo form_close();

?>
