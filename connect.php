<?php 
	$server_name = 'localhost';
	$user_name = 'root';
	$password = '';
	$database_name = 'dbfanbasecafe';

	$connection = new mysqli($server_name, $user_name,$password,$database_name);
	
	if (!$connection){
		die (mysqli_error($mysqli));
	}
		
?>