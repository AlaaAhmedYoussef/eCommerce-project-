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

			if ($do == 'Manage'){ // for manage page

				// get all data fro DB to use it 

				$stmt = $conn->prepare("SELECT * FROM Users WHERE  GroupID != 1"); 

				 $stmt->execute();

				 $rows = $stmt->fetchAll();

				?> 
			
				<div class="container">

				 	<h1 class="text-center" >Manage Members</h1>
					<div class="table-reponsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Username</td>
								<td>Email</td>
								<td>Full Name</td>
								<td>Registered Date</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['UserID'] . "</td>";
										echo "<td>" . $row['Username'] . "</td>";
										echo "<td>" . $row['Email'] . "</td>";
										echo "<td>" . $row['FullName'] . "</td>";
										echo "<td>" . " " . "</td>";
										echo "<td>
											<a href='members.php?do=Edit&userid=" . $row['UserID'] . " ' class='btn btn-success'>Edit</a> 
										 	<a href='members.php?do=Delete&userid=" . $row['UserID'] . " ' class='btn btn-danger confirm'>Delete</a>
										       </td>";
									echo "</tr>";	
								}
								
							 ?>
							

							
						</table>
					</div>
					
		
					<a href='members.php?do=Add' class="btn btn-primary"> <i class="fa fa-plus"></i> Add New Member</a>
				</div>

			<?php  } elseif ($do == 'Add') {  //Add members page ?>
				
				<div class="container">
				 	<h1 class="text-center" >Add New Member</h1>
				 	<form class="form-horizontal" method="POST" action="?do=Insert" > 
						
					
				 		<!-- Start Username field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Username</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="username" class="form-control"  autocomplete="off" required= "required" placeholder="Username to login">
				 			</div>	
				 		</div>
				 		<!-- End Username field-->

						<!-- Start Password field-->
						<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Password</label>
				 			<div class="col-sm-10 col-md-6">

				 			<input type="password" name="password" class="password form-control" autocomplete="new-password" required= "required" placeholder="password must be Hard & Complex">
							<i class="show-pass fa fa-eye fa-2x"></i>
				 			</div>	
				 		</div>
				 		<!-- start email field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Email</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="email" name="email" class="form-control"  required= "required" placeholder="Email must be Valid">
				 			</div>	
				 		</div>
				 		<!-- End email field-->

				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Fullname</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="Fullname" class="form-control"  required= "required" placeholder="Full name appears in your profile page">
				 			</div>	
				 		</div>
				 		<!-- End Fullname field-->

				 		<!-- Start submit field-->
				 		<div class="form-group form-group-lg">
				 			<div class="col-sm-offset-2 col-sm-10">
				 				<input type="submit" value="Add Member" class="btn btn-primary btn-lg">
				 			</div>	
				 		</div>
				 		<!-- End submit field-->

				 	</form>
				 </div>

			<?php  
			} elseif ($do == 'Insert') {  // for insert

				// echo $_POST['username'] . $_POST['password'] . $_POST['email'] .$_POST['Fullname'];
				
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 		echo "<h1 class='text-center'> Insert members </h1>";
			 		echo "<div class='container'>";
				 		
				 	$username = $_POST['username'];	
				 	$email = $_POST['email'];	
				 	$fullname = $_POST['Fullname'];	
				 		
				 	

				 	// password trick 

				 	$pass = $_POST['password'];

				 	$hashedPass = sha1($_POST['password']);

				 	// validation for the form 

				 	$formErrors = array();



				 	// if(empty($username))
				 	// {
				 	// 	$formErrors[] = "<div class='alert alert-danger'>username cant be <strong>empty</strong> </div>";
				 	// 	} elseif (strlen($username) < 4) {
				 	// 		$formErrors[] = "<div class='alert alert-danger'>username cant be less than <strong>4 characters </strong> </div>";
				 	// 	} elseif(strlen($username) > 20){
				 	// 		$formErrors[] = "<div class='alert alert-danger'>username cant be more than <strong>20 characters </strong> </div>";
				 	// }

				 	// if(empty($email))
				 	// {
				 	// 	$formErrors[] = "<div class='alert alert-danger'>email cant be <strong>empty</strong> </div>";
				 	// }

				 	// if(empty($fullname))
				 	// {
				 	// 	$formErrors[] = "<div class='alert alert-danger'>fullname cant be <strong>empty</strong> </div>";
				 	// }

				 	// foreach ($formErrors as $error) {
				 		
				 	// 	echo $error . "<br/>";
				 	// }

				 	// this way is better 

				 	if(empty($username))
				 	{
				 		$formErrors[] = "username cant be <strong>empty</strong> ";
				 		} elseif (strlen($username) < 4) {
				 			$formErrors[] = "username cant be less than <strong>4 characters </strong> ";
				 		} elseif(strlen($username) > 20){
				 			$formErrors[] = "username cant be more than <strong>20 characters </strong> ";
				 	}

					if(empty($pass))
				 	{
				 		$formErrors[] = "password cant be <strong>empty</strong> ";
				 	}
				 	if(empty($email))
				 	{
				 		$formErrors[] = "email cant be <strong>empty</strong> ";
				 	}

				 	if(empty($fullname))
				 	{
				 		$formErrors[] = "fullname cant be <strong>empty</strong> ";
				 	}

				 	foreach ($formErrors as $error) {
				 		
				 		echo "<div class='alert alert-danger'>" . $error . "</div>";
				 	}



				 	// if there is no error insert to DB

				 	 if(empty($formErrors)) {

				 	 	// insert the DB with this info
				 	 	$stmt = $conn->prepare("INSERT INTO Users (Username, Password, Email, FullName) 
				 	 		VALUES (:zname, :zpass, :zmail, :zfull)"); 

				 	 	$stmt->execute(array(
						 	
						 	'zname'     	=> 	$username,
						 	'zpass' 		=> 	$hashedPass, 
						 	'zmail'		=> 	$email, 
						 	'zfull' 		=>	$fullname
						 	
						 ));

				 	 	echo  "<div class='alert alert-success'>" . $stmt->rowCount() . " record is Inserted </div>";
					// echo $_POST['username'];	
				 // 	echo  $_POST['email'];	
				 // 	echo  $_POST['Fullname'];	
				 		
				 	

				 // 	// password trick 

				 // 	echo  $_POST['password'];

				 // 	echo  sha1($_POST['password']);
				 	 }
				 	


				} else {
					$errorMsg = "Sorry you can't browser this page directly" ; 

					redirectHome($errorMsg);
				}

				echo "</div>";


			} elseif ($do == 'Edit') {  //edit member page 

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
				 				<input type="text" name="username" class="form-control" value="<?php echo $row['Username']; ?>" autocomplete="off">
				 			</div>	
				 		</div>
				 		<!-- End Username field-->

						<!-- Start Password field-->
						<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Password</label>
				 			<div class="col-sm-10 col-md-6">

				 				<input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
				 				<input type="password" name="newpassword" class="form-control" autocomplete="new-password">
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
				}  else {   // else for  "if cout > 0" 
				echo "wrong id";
			}







			 } // if it is " do Edit  page ''
			 elseif ($do == 'Update') {
			 	
			 	if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 		echo "<h1 class='text-center'> Update members </h1>";
			 		echo "<div class='container'>";
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
				 		$formErrors[] = "username cant be <strong>empty</strong> ";
				 		} elseif (strlen($username) < 4) {
				 			$formErrors[] = "username cant be less than <strong>4 characters </strong> ";
				 		} elseif(strlen($username) > 20){
				 			$formErrors[] = "username cant be more than <strong>20 characters </strong> ";
				 	}

				 	if(empty($email))
				 	{
				 		$formErrors[] = "email cant be <strong>empty</strong> ";
				 	}

				 	if(empty($fullname))
				 	{
				 		$formErrors[] = "fullname cant be <strong>empty</strong> ";
				 	}

				 	foreach ($formErrors as $error) {
				 		
				 		echo "<div class='alert alert-danger'>" . $error . "</div>";
				 	}


				 	// if there is no error update to DB

				 	if(empty($formErrors)) {
				 		//update the DB with this info

					 	$stmt = $conn->prepare("UPDATE  Users  SET  Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");  //means 1 result

						$stmt->execute(array($username, $email, $fullname, $pass, $userid));
						
						echo  "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is updated </div>";
				 	}
				 	


				 	//update the DB with this info

				 // 	$stmt = $conn->prepare("UPDATE  Users  SET  Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");  //means 1 result

					// $stmt->execute(array($username, $email, $fullname, $pass, $userid));
					
					// echo $stmt->rowCount() . " record is updated";

				

				} else {
					echo "you can't browser this page directly" ; 
				}

				echo "</div>";

			 } elseif ($do == 'Delete') { //Delete member page

			 	echo "<h1 class='text-center'> Deleted members </h1>";
			 		echo "<div class='container'>";

			 	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				

				//check if UserID exist in DB

				$stmt = $conn->prepare("SELECT *  FROM  Users  WHERE  UserID = ? LIMIT 1");  //means 1 result

				$stmt->execute(array($userid));
				
				$count = $stmt->rowCount();

				
				
				if ($count > 0 ) {  

					$stmt = $conn->prepare("DELETE FROM Users WHERE UserID = :zuser");  //means 1 result

					$stmt->bindParam(":zuser", $userid);

					$stmt->execute();
						
					echo  "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is deleted </div>";

			 	} else {
			 		echo "This ID is not exist";
			 	}

			 	echo "</div>";
			 }
			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}

 ?>
