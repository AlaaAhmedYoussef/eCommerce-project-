<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?php getTitle(); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery-ui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.selectBoxIt.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>front.css">

	</head>
	<body>
	<div class="upper-bar">
		<div class="container">
		<?php 

		if (isset($_SESSION['user'])) {  //dont write here $sessionUser bec the variable is exist

			echo "welcome " . $sessionUser . '  ';
			
			echo "<a href='profile.php'>My Profile</a>";

			echo " - <a href='newad.php'>New Ad</a>";

			echo " - <a href='logout.php'>Logout</a>";

			$userStatus = checkUserStatus($sessionUser);

			//here 1 mean not activated
			if ($userStatus == 1)  {
				echo "your membership need to be activated";
			}

		} else {
		?>
		<a href="login.php">
				<span class="pull-right">Login/Signup</span>
			</a>
		<?php  }  ?>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
		<div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">HomePage</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="app-nav">
		      <ul class="nav navbar-nav navbar-right">
		        <?php 
		        		foreach (getCat() as $cat) {
		        			
		        			echo '<li><a href="categories.php?pageid=' . $cat['ID']. '&pagename=' . str_replace(' ', '-', $cat['Name']) . ' ">' . $cat['Name'] . '</a></li>';

		        		}

		         ?>
		       </ul>
		</div><!-- /.navbar-collapse -->
		</div><!-- /.container -->
	</nav>	