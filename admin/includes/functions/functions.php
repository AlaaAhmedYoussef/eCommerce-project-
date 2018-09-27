<?php 

	/*
	Title function that echo the page title in case the page has the variable $pageTitle and 
	echo Default Title for other pages
	*/

	// if  (isset($pageTitle)) {
	// 	$title = $pageTitle;
	// } else {
	// 	$title = 'any title';
	// }
	// $title = isset($pageTitle) ? $pageTitle : 'any title';
	// echo $title;

	//using functions

	function getTitle()  {

		global $pageTitle;
 	
		if  (isset($pageTitle)) {

			echo  $pageTitle;

		} else {

			echo 'Default';
		}

	}

 ?>