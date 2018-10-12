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

	/*
	getTitle()  v1.0
	Title function that echo the page title in case the page has the variable $pageTitle and 
	echo Default Title for other pages
	*/

	function getTitle()  {

		global $pageTitle;
 	
		if  (isset($pageTitle)) {

			echo  $pageTitle;

		} else {

			echo 'Default';
		}

	}


	/* redirectHome  v1.0	
	redirectHome function [accept parameters]
	$errorMsg = echo the error message
	$seconds = wait seconds before redirecting 
	*/	

	// function redirectHome($errorMsg, $seconds = 3)   {

	// 	echo "<div class='alert alert-danger'>$errorMsg</div>";

	// 	echo "<div class='alert alert-info'>You will be Redirected to Homepage After $seconds Seconds.</div>";

	// 	header("refresh:$seconds;url=index.php");
		
	// 	exit();
	// }

	/* redirectHome  v2.0	
	redirectHome function [accept parameters]
	$theMsg = can be [ error  | success | warning ]
	$url = the link you want ro redirect to 
	$seconds = wait seconds before redirecting 
	*/
		function redirectHome($theMsg, $url = null, $seconds = 3)   {

		if ($url === null)  {
			
			$url = 'index.php';

			$link = 'Homepage';

		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ' ')  {

				$url = $_SERVER['HTTP_REFERER'];

				$link = 'Previous Page';
			} else {


				$url = 'index.php';

				$link = 'Homepage';

			}

		}	

		echo $theMsg;

		echo "<div class='alert alert-info'>You will be Redirected to $link After $seconds Seconds.</div>";

		header("refresh:$seconds;url=$url");
		
		exit();
	}

	/* checkItem()   v1.0	
	function to check for item in database if exist before [accept parameters]
	$select = the Item to select [example for item can be  "user , item, category, ..."]
	$from = the table to select from  [example for the table  "users , items , categories, ..."]
	$value = the value of the select [if you select user then value can be " alaa , mohamed , ...""]
	*/	

	function checkItem($select, $from, $value)  {

		global $conn;

		$statment = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statment->execute(array($value));
		
		$count = $statment->rowCount();

		return $count;		// not echo because you dont need to print it	     
	}
 ?>