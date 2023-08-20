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
echo form_label('Liczby:', 'values');
echo form_textarea('values', $this->input->post('values'));
echo form_label('Typ bazowy:', 'base');
echo form_input('base', $this->input->post('base'));
echo form_label('Typ docelowy:', 'to');
echo form_input('to', $this->input->post('to'));
echo small('2 = BIN; 10 = DEC; 16 = HEX;');
echo form_submit('submit', 'Wylicz');
echo form_close();

?>
