<?php 


	function lang ( $phrase ) {

		static $lang =  array(

			// Dashboard Page

			//Navbar links

			'HOME_ADMIN' 	=> 'Home' ,
			'CATEGORIES' 	=> 'Categories' ,
			'ITEMS' 		=> 'items' ,
 			'MEMBERS' 		=> 'Members' ,
 			'STATISTICS' 		=> 'Statistics' ,
 			'LOGS' 		=> 'Logs' ,

 			'' => '',

			// //Home Page
			// 'MESSAGE' => 'Welcome' ,
			// 'ADMIN' => 'Administrator'

		);

		return $lang[$phrase];
	}


 ?>