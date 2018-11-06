<?php  
	
	//error reporting
	
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);


	include 'admin/connect.php';

	$sessionUser = '';
	if (isset($_SESSION['user'])) {

		$sessionUser = $_SESSION['user'];
	}


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
	


?>