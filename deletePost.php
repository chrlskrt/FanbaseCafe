<?php
    include ("includes/api.php");

    // getting inputs of form submission
    $fanbase_id = $_POST['fanbase_id'];
    $post_id = $_POST['post_id'];

    $sqlDeletePost = "DELETE FROM tblPost WHERE post_id = {$post_id}";
    $resultpost = mysqli_query($connection, $sqlDeletePost);

    header("Location: fanbase.php?fanbase_ID={$fanbase_id}");
    exit();
?>