<?php  

	include 'connect.php';
	//Routes

	$tpl = 'includes/templates/';  //for Templates Directory
	$lang =  'includes/languages/';
	$func =  'includes/functions/';
	$css = 'layout/css/'; //for Css Directory
	$js = 'layout/js/'; //for JS Directory
	


	//include the important files

	include $lang . 'english.php';  // should be first
	include $func . 'functions.php';
	include $tpl . 'header.php'; 
	
	//include Navbar in all expext pages with $noNavbar

	if  (!isset($noNavbar)) { include $tpl . 'navbar.php'; 	}
	
?>