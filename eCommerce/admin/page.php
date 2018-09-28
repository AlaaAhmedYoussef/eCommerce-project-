
                                                              <!-- this page isn't a part of my project  -->

<?php 

	
	/*
		
		Categories = > [Manage    |  Edit | update |    Add | insert |    Delete |    Stats ]
	*/

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	// redirect him to manage page if wrong input 

	if ($do == 'Manage'){
		echo 'Welome You are in manage category page';
		echo '<a href="?do=Insert">Add new cateory + </a>';

	}  elseif ($do == 'Add') {
		echo 'Welome You are in Add category page';

	}   elseif ($do == 'Insert') {
		echo 'Welome You are in insert category page';

	} else {
		echo 'Error there\'s no page with this name';
	}







 ?>




 