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

		// here for signup form	
		} else 	{ 

			// $test = $_POST['username'];

			$formErrors = array();

			$username 	= $_POST['username'];
			$password 	= $_POST['password'];
			$password2 	= $_POST['password2'];
			$email 		= $_POST['email'];

			//For Username validation
			if (isset($username)) {

				$filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
				
				// echo $filterdUser;

				if (strlen($filterdUser) < 4) {

					$formErrors[] = 'Username Must Be Larger Than 4 Characters ';
				}
			}

			//For Password validation
			if (isset($password) && isset($password2)) {

				if (empty($password)) {

					$formErrors[] = 'Sorry Password Can\'t be Empty ';
				}

				// $pass1 = sha1($password);
				// $pass2 = sha1($password2);				
				
				if (sha1($password) !== sha1($password2)) {

					$formErrors[] = 'Sorry Password is Not Match ';
				}
			}

			//For Email validation
			if (isset($email)) {

				$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
				
				
				if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

					$formErrors[] = 'This Email is Not Valid ';
				}
			}

			// if there is no error insert to DB

			 if(empty($formErrors)) {

				// check if user exist 
				 $check = checkItem("Username", "users", $username);

				 if ($check == 1)  {

				 	 $formErrors[] = 'Sorry This User is Exist ';

				 

			 	} else {

					 // insert the user in DB with this info
					$stmt = $conn->prepare("INSERT INTO users (Username, Password, Email, RegStatus, Date) 
					 	 		VALUES (:zname, :zpass, :zmail, 0, now())"); 

					 $stmt->execute(array(
								 	
								'zname'     	=> 	$username,
								'zpass' 		=> 	sha1($password), 
								'zmail'		=> 	$email 
																 	
						));

					$successMsg = 'Congrats you are Now Registered user ';

				}
				
			 }			
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
		<!-- <?php echo $test; ?>	 -->
		<?php 

			if (!empty($formErrors)){

				foreach ($formErrors as $error) {
					
					// echo $error . '<br>';
					echo '<div class="msg error">' . $error . '</div>';

				}
			}

			if (isset($successMsg)) {

				echo '<div class="msg success">' . $successMsg . '</div>';
			}

		 ?>
		</div>
		




	</div>

<?php 
	include $tpl . 'footer.php';
	ob_end_flush();
?>