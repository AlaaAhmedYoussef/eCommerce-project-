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

			} elseif ($do == 'Edit') {  //edit page 

				// if ( isset($_GET['userid']) && is_numeric($_GET['userid'])) {

				// 	echo intval($_GET['userid']);

				// } else {

				// 	echo 0;
				// }
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				// echo $userid;

				//check if UserID exist in DB

				$stmt = $conn->prepare("SELECT *  FROM  Users  WHERE  UserID = ? LIMIT 1");  //means 1 result

				$stmt->execute(array($userid));
				$row = $stmt->fetch();   //to get data from DB and put it in $row which is an array 
				$count = $stmt->rowCount();

				
				
				if ($count > 0 ) { 

					// echo "This is the edit form";
					// echo $row['Username'] . " " . $row['Password'] ;

				?>
				
				
				 
				 <div class="container">
				 	<h1 class="text-center" >Edit Member</h1>
				 	<form class="form-horizontal">
				 		<!-- Start Username field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Username</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="username" class="form-control" value="<?php echo $row['Username']; ?>" autocomplete="off">
				 			</div>	
				 		</div>
				 		<!-- End Username field-->

						<!-- Start Password field-->
						<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Password</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="password" name="password" class="form-control" autocomplete="new-password">
				 			</div>	
				 		</div>
				 		<!-- End  password field-->

						<!-- start email field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Email</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="email" name="email" class="form-control" value="<?php echo $row['Email']; ?>">
				 			</div>	
				 		</div>
				 		<!-- End email field-->

				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Fullname</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="Fullname" class="form-control" value="<?php echo $row['FullName']; ?>">
				 			</div>	
				 		</div>
				 		<!-- End Fullname field-->

				 		<!-- Start submit field-->
				 		<div class="form-group form-group-lg">
				 			<div class="col-sm-offset-2 col-sm-10">
				 				<input type="submit" value="Save" class="btn btn-primary btn-lg">
				 			</div>	
				 		</div>
				 		<!-- End submit field-->

				 	</form>
				 </div>
			<?php  
			// if this id not exist
				}  else {
				echo "wrong id";
			}







			 } // if it is " do Edit  page ''

			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}

 ?>