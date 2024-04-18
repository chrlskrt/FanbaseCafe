<?php
    include ("includes/api.php");

    // getting inputs of form submission
    $fanbase_id = $_POST['fanbase_id'];
    $event_id = $_POST['deleteEvent'];

    $sqlDeleteEvent = "DELETE FROM tblEvent WHERE event_id = {$event_id}";
    $resultevent = mysqli_query($connection, $sqlDeleteEvent);

    header("Location: fanbase.php?fanbase_ID={$fanbase_id}");
    exit();
?>