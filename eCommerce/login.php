<?php
	ob_start();
	session_start();
	$pageTitle = 'Login';
	if (isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	include 'init.php';

	// Check IF USER Coming from HTTP Post Request

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (isset($_POST['login']))  {

			$user = $_POST['username'];
			$pass = $_POST['password'];
			$hashedPass = sha1($pass);

			//check if User exist in DB

			$stmt = $conn->prepare("SELECT 
							 Username, Password 
						     FROM 
						     	users 
						     WHERE 
						     	Username = ?
						     AND 
						     	Password = ? ");  

			$stmt->execute(array($user, $hashedPass));
			
			$count = $stmt->rowCount();

			//if count > 0 this mean the DB contains record for this userrname

			if ($count > 0 ) {

				$_SESSION['user'] = $user;  // Register session name
				
				header('Location: index.php'); //redirect to home page
				exit();
			}

		} else 	{ 

			$test = $_POST['username'];
		}
	 }

?>

	<div class="container login-page">
		<h1 class="text-center">
			<span class="selected" data-class="login">Login</span> | 
			<span data-class="signup">Signup</span>
		</h1>
		<!-- Start Login Form -->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
				<input 
					class="form-control" 
					type="text" 
					name="username" 
					autocomplete="off"
					placeholder="Type your username" 
					required />
			</div>
			<div class="input-container">
				<input 
					class="form-control" 
					type="password" 
					name="password" 
					autocomplete="new-password"
					placeholder="Type your password" 
					required />
			</div>
			<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
		</form>
		<!-- End Login Form -->
		<!-- Start Signup Form -->
		<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
				<input 
					pattern=".{4,}"
					title="Username Must Be Between 4 Chars"
					class="form-control" 
					type="text" 
					name="username" 
					autocomplete="off"
					placeholder="Type your username" 
					required />
			</div>
			<div class="input-container">
				<input 
					minlength="4"
					class="form-control" 
					type="password" 
					name="password" 
					autocomplete="new-password"
					placeholder="Type a Complex password" 
					required />
			</div>
			<div class="input-container">
				<input 
					minlength="4"
					class="form-control" 
					type="password" 
					name="password2" 
					autocomplete="new-password"
					placeholder="Type a password again" 
					required />
			</div>
			<div class="input-container">
				<input 
					class="form-control" 
					type="email" 
					name="email" 
					placeholder="Type a Valid email" />
			</div>
			<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
		</form>
		<!-- End Signup Form -->
		<div class="the-errors text-center">
		<?php echo $test; ?>	
		</div>
		




	</div>

<?php 
	include $tpl . 'footer.php';
	ob_end_flush();
?>