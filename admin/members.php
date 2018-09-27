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
				 	<form class="form-horizontal" method="POST" action="?do=Update" > 
						
						<!-- send also id -->
						<input type="hidden" name="userid" value="<?php echo $row['UserID']; ?>">

				 		<!-- Start Username field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Username</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="username" class="form-control" value="<?php echo $row['Username']; ?>" autocomplete="off" required= "required">
				 			</div>	
				 		</div>
				 		<!-- End Username field-->

						<!-- Start Password field-->
						<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Password</label>
				 			<div class="col-sm-10 col-md-6">

				 				<input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
				 				<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave it blank if you don't need to change it">
				 			</div>	
				 		</div>

				 		<!-- <div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Confirm Password</label>
				 			<div class="col-sm-10 col-md-6">

				 				<input type="password" name="confpassword" class="form-control" autocomplete="new-password">
				 			</div>	
				 		</div> -->

				 		<!-- End  password field-->

						<!-- start email field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Email</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="email" name="email" class="form-control" value="<?php echo $row['Email']; ?>"  required= "required">
				 			</div>	
				 		</div>
				 		<!-- End email field-->

				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Fullname</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="Fullname" class="form-control" value="<?php echo $row['FullName']; ?>" required= "required">
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
			 elseif ($do == 'Update') {
			 	
			 	if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 		echo "<h1 class='text-center'> Update members </h1>";
			 		echo "<div class='container'>"
			 		;
				 	$userid = $_POST['userid'];	
				 	$username = $_POST['username'];	
				 	$email = $_POST['email'];	
				 	$fullname = $_POST['Fullname'];	
				 		
				 	// echo $userid . $user . $email . $fullname;

				 	// password trick 

				 	// $pass = '';

				 	// if (empty($_POST['newpassword'])) {
				 		
				 	// 	$pass = $_POST['oldpassword'];

				 	// } else {

				 	// 	if ($_POST['newpassword'] == $_POST['confpassword']){
						// 	$pass = sha1($_POST['newpassword']);

						// } else {
						// 	echo "the password and the confirm pass don't match";
						// 	$pass = $_POST['oldpassword'];
						// }
				 	// }

				 
				 	$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);


				 	// validation for the form 

				 	$formErrors = array();

				 	if(empty($username))
				 	{
				 		$formErrors[] = "<div class='alert alert-danger'>username cant be <strong>empty</strong> </div>";
				 		} elseif (strlen($username) < 4) {
				 			$formErrors[] = "<div class='alert alert-danger'>username cant be less than <strong>4 characters </strong> </div>";
				 		} elseif(strlen($username) > 20){
				 			$formErrors[] = "<div class='alert alert-danger'>username cant be more than <strong>20 characters </strong> </div>";
				 	}

				 	if(empty($email))
				 	{
				 		$formErrors[] = "<div class='alert alert-danger'>email cant be <strong>empty</strong> </div>";
				 	}

				 	if(empty($fullname))
				 	{
				 		$formErrors[] = "<div class='alert alert-danger'>fullname cant be <strong>empty</strong> </div>";
				 	}

				 	foreach ($formErrors as $error) {
				 		
				 		echo $error . "<br/>";
				 	}


				 	// if there is no error update to DB

				 	if(empty($formErrors)) {
				 		//update the DB with this info

					 	$stmt = $conn->prepare("UPDATE  Users  SET  Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");  //means 1 result

						$stmt->execute(array($username, $email, $fullname, $pass, $userid));
						
						echo  "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is updated </div>";
				 	}
				 	

				 	

				echo "</div>"; // for container

				} else {
					echo 'that isn\'t a post request'; 
				}
			 }
			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}

 ?>
