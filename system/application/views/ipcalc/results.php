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
<?php foreach($results as $result):
	  $cidr = $result['mask']->get_cidr(); ?>
<table class="results">
	<thead><tr><td>Właściwość</td><td>Dziesiętnie</td><td>Binarnie</td><td>Operacje</td></tr></thead>
	<tr><td class="description">Adres IP:</td><td class="big"><?php echo $result['ip']->get() ?></td><td><?php echo addrbold($result['ip']->get_bin(), $cidr) ?></td><td></td></tr>
	<tr><td class="description">Maska:</td><td><?php echo $result['mask']->get().' = '.$cidr ?></td><td><?php echo addrbold($result['mask']->get_bin(), $cidr) ?></td><td></td></tr>
	<tr><td class="description">Podsieć:</td><td><?php echo $result['subnet']->get() ?></td><td><?php echo addrbold($result['subnet']->get_bin(), $cidr) ?></td><td>IP & MASK</td></tr>
	<tr><td class="description">Broadcast:</td><td><?php echo $result['brodcast']->get() ?></td><td><?php echo addrbold($result['brodcast']->get_bin(), $cidr) ?></td><td>IP | ~(MASK)</td></tr>
	<tr><td class="description">Pierwszy host:</td><td><?php echo $result['first']->get() ?></td><td><?php echo addrbold($result['first']->get_bin(), $cidr) ?></td><td>SUBNET + 1</td></tr>
	<tr><td class="description">Ostatni host:</td><td><?php echo $result['last']->get() ?></td><td><?php echo addrbold($result['last']->get_bin(), $cidr) ?></td><td>BROADCAST - 1</td></tr>
	<tr><td class="description">Liczba hostów:</td><td><?php echo $result['noh'] ?></td><td><?php echo decbin($result['noh'])?></td><td></td></tr>
	<tr><td class="description">Liczba podsieci:</td><td><?php echo $result['nos'] ?></td><td><?php echo decbin($result['nos'])?></td><td></td></tr>
</table>

<?php endforeach; ?>
