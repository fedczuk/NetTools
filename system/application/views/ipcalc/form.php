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
	echo form_label('Adresy IP:', 'values');
	echo form_textarea('values', $this->input->post('values'));
	echo small('Adresy w postaci: IP/MASKA');
	echo form_submit('submit', 'Wylicz');
	echo form_close();

?>
