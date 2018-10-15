<?php 

/*
   template page
*/
   	ob_start();   // Output buffering start .. wait for header to be sent first 

	session_start();
	
	$pageTitle ='';

		if (isset($_SESSION['Username'])) {

			

			include 'init.php';

			//here all things go 

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


			//start manage page 

			if ($do == 'Manage'){ // for manage page

			 } elseif ($do == 'Add') {  //Add members page 
			} elseif ($do == 'Insert') {  // for insert

				

			} elseif ($do == 'Edit') {  //edit member page 

				


			 } // if it is " do Edit  page ''
			 elseif ($do == 'Update') {
			 	
			 } elseif ($do == 'Delete') { //Delete member page

			 
			 }  elseif ($do == 'Activate') { //for active pending member
			 	
			 	

			 }
			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}


	ob_end_flush();  // Release the output
 ?>
