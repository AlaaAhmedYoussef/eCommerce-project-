<?php 
	session_start();
		
		if (isset($_SESSION['Username'])) {

			$pageTitle ='Dashboard';

			include 'init.php';

			// echo 'Welcome ' . "in your dashboard ". $_SESSION["Username"]; 

			// echo "welcome " .$_SESSION['Username'] . " and id is " . $_SESSION['ID'];
			// print_r($_SESSION) ;

			
			
			include $tpl . 'footer.php'; 

		} else {
			// echo "You are not authorized to view this page";

			header('Location: index.php'); 

			exit();
		}



 ?>