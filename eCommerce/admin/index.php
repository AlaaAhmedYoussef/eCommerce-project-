<?php 
	session_start();
	// print_r($_SESSION);
	$noNavbar = '';
	$pageTitle ='Login';
	if (isset($_SESSION['Username'])) {
		header('Location: dashboard.php'); //redirect to dashboard page
	}
	include "init.php";
	

	// Check IF USER Coming from HTTP Post Request

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);

		 // echo $username . "  ". $password;
		// echo $hashedPass;

		//check if User exist in DB

		$stmt = $conn->prepare("SELECT 
						UserID, Username, Password 
					     FROM 
					     	users 
					     WHERE 
					     	Username = ?
					     AND 
					     	Password = ? 
					    AND 
					    	GroupID = 1
					    LIMIT 1");  //means 1 result

		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();   //to get data from DB and put it in $row which is an array 
		$count = $stmt->rowCount();

		// echo $count;

		//if count > 0 this mean the DB contains record for this userrname

		if ($count > 0 ) {

			// //to test the fetch of data
			// print_r($row);

			$_SESSION['Username'] = $username;  // Register session name
			$_SESSION['ID'] = $row['UserID']; // Register session ID
			header('Location: dashboard.php'); //redirect to dashboard page
			exit();
		}
	 }
?>

<!-- 
 	<?php 

		echo lang('MESSAGE') . ' ' . lang('ADMIN');
 	?>
 -->


	<form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
		<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
		<input class="btn btn-primary btn-block" type="submit" value="Login">
	</form>


<!-- testing
	Welcome To  Index
	 <div class="btn btn-danger btn-block">Test BootStrap</div>
	
	<i class="fa fa-home fa-5x">	</i>
-->
	


<?php 	include $tpl . 'footer.php'; ?>




