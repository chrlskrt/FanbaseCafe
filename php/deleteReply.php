<?php
    include ("../connect.php");
    include ("../includes/api.php");

    // getting inputs of form submission
    $fanbase_id = $_POST['fanbase_id'];
    $reply_id = $_POST['reply_id'];

    $sqlGetPostID = "SELECT post_id FROM tblreply WHERE reply_id = $reply_id";
    $post_id = mysqli_fetch_assoc(mysqli_query($connection, $sqlGetPostID))['post_id'];
    $sqlDeleteReply = "DELETE FROM tblreply WHERE reply_id = {$reply_id}";
    $resultreply = mysqli_query($connection, $sqlDeleteReply);

    header("Location: ../fanbase.php?fanbase_ID={$fanbase_id}&post={$post_id}");
    exit();
?>