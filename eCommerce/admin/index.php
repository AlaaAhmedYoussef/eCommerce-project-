<?php 
	session_start();
	// print_r($_SESSION);
	$noNavbar = '';
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

		$stmt = $conn->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
		$stmt->execute(array($username, $hashedPass));
		$count = $stmt->rowCount();

		// echo $count;

		//if count > 0 this mean the DB contains record for this userrname

		if ($count > 0 ) {
			// echo "welcome " . $username;
			$_SESSION['Username'] = $username;  // Register session name
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




