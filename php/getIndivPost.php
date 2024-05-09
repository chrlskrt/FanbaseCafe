<?php
    include("../../connect.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $post_id = $_POST['post_id'];

        $sqlGetPost = "SELECT post_id, fanbase_id FROM tblPost WHERE post_id = {$post_id}";
        $resultPost = mysqli_fetch_assoc(mysqli_query($connection, $sqlGetPost));

        echo (json_encode($resultPost));
    }
?>