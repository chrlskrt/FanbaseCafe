<?php
    include("connect.php");
  
    /* using cookie */ 
    // $current_user = (isset($_COOKIE['user'])) ? unserialize(base64_decode(urldecode($_COOKIE['user']))) : null;

    /* using session */
    session_start();
    $current_user = null;

    // to store current user using the forum
    if (isset($_SESSION["user"])){
        $current_user = json_decode($_SESSION["user"], true);
    }


    function handleLogIn($user){
        // /* using cookie */
		// $logInCookie = urlencode(base64_encode(serialize($user)));
        // setcookie('user', $logInCookie, time() + (86400 * 30), "/");

        /* using session */
        $_SESSION["user"] = json_encode($user, true);
	}

?>