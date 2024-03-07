<?php 
	$connection = new mysqli('localhost', 'root','','dbRepuestoF1');
	
	if (!$connection){
		die (mysqli_error($mysqli));
	}
		
?>