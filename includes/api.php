<?php
    include("utilities/getFanbases.php");
    include("utilities/getEvents.php");    
    include("utilities/getPosts.php");
    include("utilities/getReplies.php");
    include("utilities/getFanbaseMembersTable.php");
    include("utilities/manageAppTables.php");
    
    session_start();
    $current_user = null;

    // to store current user using the forum
    if (isset($_SESSION["user"])){
        $current_user = json_decode($_SESSION["user"], true);
    }

    date_default_timezone_set("Asia/Manila");
?>