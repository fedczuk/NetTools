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

?>
<div id="menu">
	<h1>NetCalculations Tools</h1>
	<?php echo anchor('ascii', 'Konwerter kodów ASCII'); ?>
	<?php echo anchor('numbers', 'Konwerter liczb'); ?>
	<?php echo anchor('ipcalc', 'Kalkulator IPv4'); ?>
	<?php echo anchor('netcalc', 'Kalkulator podsieci'); ?>
	<?php echo anchor('multicast', 'Kalkulator adresów sprzętowych multicast'); ?>
	<?php echo anchor('modulation', 'Modulacja'); ?>
</div>
