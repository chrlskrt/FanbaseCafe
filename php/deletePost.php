<?php
    include ("../connect.php");
    include ("../includes/api.php");

    // getting inputs of form submission
    $fanbase_id = $_POST['fanbaseID'];
    $post_id = $_POST['postID'];

    $sqlDeletePost = "DELETE FROM tblPost WHERE post_id = {$post_id}";
    $resultpost = mysqli_query($connection, $sqlDeletePost);

    header("Location: ../fanbase.php?fanbase_ID={$fanbase_id}");
    exit();
?>