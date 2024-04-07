<?php
    include_once("includes/api.php");

    if($_SERVER['REQUEST_METHOD']==='POST'){
		$uname = $_POST['username'];
		$pass = $_POST['password'];

		//check tbluseraccount if username is existing
		$sql ="SELECT * from tbluseraccount where username='".$uname."'";
		
		$result = mysqli_query($connection,$sql);	
		
		$user_count = mysqli_num_rows($result);
		$user = mysqli_fetch_array($result);

		if ($user_count == 1 && password_verify($pass, $user[4])){
			handleLogIn($user); // api.php ang mo set sa cookie / session 
			header("Location: index.php");
		} else if ($user_count == 0){
			header("Location: login.php?login_error_1");
		} else {
			header("Location: login.php?login_error_2=".$uname."");
		}
	}
?>