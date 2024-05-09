<?php
    include("../connect.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $event_id = $_POST['event_id'];

        $sqlGetEvent = "SELECT * FROM tblEvent WHERE event_id = {$event_id}";
        $resultEvent = mysqli_fetch_array(mysqli_query($connection, $sqlGetEvent));
        $resultEvent['event_time'] = date_format(date_create($resultEvent['event_time']), "H:i");

        echo (json_encode($resultEvent));
    }
?>