<?php 

session_start();   // to start the session

session_unset(); //to unset the data

session_destroy(); //to destroy the session

header('Location: index.php');

exit();

 ?>