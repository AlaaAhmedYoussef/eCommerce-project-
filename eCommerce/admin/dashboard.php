<?php 
	session_start();
		
		if (isset($_SESSION['Username'])) {

			include 'init.php';
			// echo 'Welcome ' . "in your dashboard ". $_SESSION["Username"]; 

			echo "welcome";

			
			include $tpl . 'footer.php'; 

		} else {
			// echo "You are not authorized to view this page";

			header('Location: index.php'); 
			exit();
		}



 ?>