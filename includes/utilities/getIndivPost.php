<?php
    include("../../connect.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $event_id = $_POST['event_id'];

        $sqlGetPost = "SELECT * FROM tblPost WHERE post_id = {$post_id}";
        $resultPost = mysqli_fetch_array(mysqli_query($connection, $sqlGetPost));

        echo (json_encode($resultPost));
    }
?>