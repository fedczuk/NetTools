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
<h3>Dane</h3>
<table class="results">
	<tr><td class="description">Podsieć:</td><td><?php echo $params['subnet'] ?></td></tr>
	<tr><td class="description">Maska:</td><td><?php echo $params['mask'].' = '.$params['cidr'] ?></td></tr>
	<tr><td class="description">Liczba hostów:</td><td><?php echo $params['addresses'] ?></td></tr>
</table>

<?php 
	foreach($results as $key => $result):
		if ($result['overflow'])
			echo div('Przekroczenie zakresu!', array('class' => 'error'));
?>
<h3>Podsieć <?php echo ($key+1).' ('.$result['hosts'].')'; ?></h3>
<table class="results">
	<tr><td class="description">Podsieć:</td><td><?php echo $result['subnet'] ?></td></tr>
	<tr><td class="description">Maska:</td><td><?php echo $result['mask'].' = '.$result['cidr'] ?></td></tr>
	<tr><td class="description">Liczba hostów:</td><td><?php echo $result['addresses'] ?></td></tr>
	<tr><td class="description">Brodcast:</td><td><?php echo $result['brodcast'] ?></td></tr>
</table>
<?php endforeach; ?>
