<?php
    include_once("includes/api.php");
    /* using cookie */
    // var_dump($_COOKIE);
    // unset($_COOKIE['user']);
    // setcookie("user", "", time()-3600);
    // var_dump($_COOKIE);
    
    /* using session */
    unset($current_user);
    session_destroy();
    header("Location: index.php");
    exit();
?>