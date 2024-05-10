<?php
    include("includes/header.php");
    $sqlUpdateIsMember = "UPDATE tbluseraccount_fanbase SET IsMember = 0 WHERE account_id = {$current_user['account_id']}";
    $sqlUpdateIsDeleted = "UPDATE tbluseraccount SET isDeleted = 1 WHERE account_id = {$current_user['account_id']}";
    // add Update tbluseraccount isDeleted = 1
    $sqlResultMember = mysqli_query($connection, $sqlUpdateIsMember);
    $sqlResultDelete = mysqli_query($connection, $sqlUpdateIsDeleted);

    if ($sqlResultMember && $sqlResultDelete){
        header("Location:php/logOutUser.php");
        exit();
    }
?>