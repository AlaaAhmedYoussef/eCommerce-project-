<?php 


	function lang ( $phrase ) {

		static $lang =  array(

			// Navbar links

			'HOME_ADMIN' => 'Home',
			

			// //Home Page
			// 'MESSAGE' => 'Welcome' ,
			// 'ADMIN' => 'Administrator'

		);

		return $lang[$phrase];
	}


 ?>