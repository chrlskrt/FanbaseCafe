<?php
    include("includes/header.php");
    $sqlDelete = "UPDATE tbluseraccount_fanbase SET IsMember = 0 WHERE account_id = {$current_user['account_id']}";

    $sqlResult = mysqli_query($connection, $sqlDelete);

    if ($sqlResult){
        header("Location:php/logOutUser.php");
        exit();
    }
?>