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
 * NetCalculations Tools - Modified CI HTML Helper
 * 
 * @package		NetCalculations Tools
 * @subpackage 	Helpers
 * @category	Helpers
 * @author		SFinX
 */

if ( ! function_exists('div')){
	
	function div($content, $params = array()){
		$p = '';
		if (!empty($params)){
			foreach($params as $k => $v)
				$p .= ' '.$k.'="'.$v.'"';
			$p .= ' ';
		}
		
		return "<div$p>$content</div>";
	}
}

if ( ! function_exists('addrbold')){
	
	function addrbold($addr, $cidr){
		$i = $cidr + intval($cidr/8);
		return substr_replace($addr, '&nbsp;&nbsp;', $i, 0);
	}
}

if ( ! function_exists('small')){
	
	function small($text){
		return "<small>$text</small>";
	}
}

?>
