<?php 

/*
   manage members page
   you can Add | Edit | Delete members from here 
*/

session_start();
		
		if (isset($_SESSION['Username'])) {

			

			include 'init.php';

			//here all things go 

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


			//start manage page 

			if ($do == 'Manage'){
				echo 'manage';
				//here manage page

			} elseif ($do == 'Edit') {
				
				//edit page

				 echo 'welcome in edit page your id is ' . $_GET['userid'];
			}

			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}

 ?>