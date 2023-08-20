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
	echo form_label('Bity', 'bits');
	echo form_input('bits', $this->input->post('bits'));
	echo form_label('Typ', 'type');
	$modulation = array(
		'nrz' => 'NRZ',
		'nrzi' => 'NRZI',
		'manchester' => 'Manchester/Phase Encoding',
		'manchesteri' => 'Manchester/Phase Encoding (I) (ETH 10BASE-T)',
		'mlt3' => 'MLT3',
	);
	echo form_dropdown('type', $modulation, $this->input->post('type'));
	echo form_submit('submit', 'Generuj');
	echo form_close();
?>
