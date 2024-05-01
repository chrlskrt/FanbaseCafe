<?php
    include ("includes/api.php");

    // getting inputs of form submission
    $fanbase_id = $_POST['fanbase_id'];
    $post_id = $_POST['post_id'];
    $reply_id = $_POST['reply_id'];

    $sqlDeleteReply = "DELETE FROM tblreply WHERE reply_id = {$reply_id}";
    $resultreply = mysqli_query($connection, $sqlDeleteReply);

    header("Location: fanbase.php?fanbase_ID={$fanbase_id}&post={$post_id}");
    exit();
?>