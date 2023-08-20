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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
   <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
   <meta name="robots" content="noindex,nofollow" />
   <link rel="icon" type="image/png" href="<?php echo base_url().'icon.png' ?>"/>
   <title><?php echo $title ?></title>
   <style>
	body {font: 12px Verdana, Arial, Helvetica, sans-serif; margin: 0px 20px 20px 20px;}
	hr {border: none; border-top: 1px solid #ccc;}
	label, input, textarea, select {display:block; margin: 3px 0px;}
	input, textarea, select {border-bottom-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px;}
	textarea {height: 100px; font: 12px Verdana, Arial, Helvetica, sans-serif;}
	input[type="text"], textarea, select {border: 1px solid #aaa; min-width: 300px; padding: 3px;}
	textarea:focus, input[type="text"]:focus, select:focus {border: 1px solid #000;}
	form small {color: #333; font-size: 10px;}
	a, a:link, a:visited {color: #0033cc; text-decoration: none;}
	a:hover {color: #36afdc;}
	h3 {margin: 0px; padding: 0px;}
	#result {margin: 0px 20px; width: auto;}
	.message, .error {color: #FF0000; font-weight: bold;}
	.error {margin-bottom: 20px; border-bottom: 1px solid #ff0000; font-size: 1.2em;}
	.big {font-size: 18px; font-weight: bold;}
	.results {margin: 0px 0px 20px 0px;}
	.results td.description {text-align: right;}
	.results td {padding: 3px; text-align: left;}
	.results thead td {font-size: 14px; font-weight: bold; text-align: center;}
	#menu {border-bottom-left-radius: 10px; -moz-border-radius-bottomleft: 10px; -webkit-border-bottom-left-radius: 10px;
		position: fixed; top: 0; right: 0; padding: 0px 20px 20px 20px; background: #fff; 
		border-left: 1px solid #ccc; border-bottom: 1px solid #ccc;}
	#menu a {display: block; margin-left: 10px;}
   </style>
</head>
<body onload="document.forms[0].elements[0].focus()">
	<?php echo $this->load->view('menu', '', TRUE); ?>
    <h1><?php echo $title ?></h1>
    <hr/>
	
	<?php 
		$messages = validation_errors(); 
		if (!empty($messages)): 
	?>
	<div class="message"><?php echo $messages ?></div>
	<?php endif; ?>
	
    <?php echo $content ?>
	
	<?php if (isset($results)): ?>
	<hr/>
    <h2>Wynik</h2>
	<div id="result"><?php echo $results ?></div>
	<?php endif; ?>
	
    <hr/>
    <small>&copy; 2009 by SFinX; Czas wykonania: {elapsed_time}; Pamięć: {memory_usage}</small> 
</body>
</html>
