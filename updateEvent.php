<?php
    include ("includes/api.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // getting inputs of form submission
        $event_id = $_POST['event_id'];
        $event_name = $_POST['event_name'];
        $event_type = $_POST['event_type'];
        $event_date = $_POST['event_date'];
        $event_time = $_POST['event_time'];
        $event_location = $_POST['event_location'];
        $event_description = $_POST['event_description'];
        $fanbase_id = $_POST['fanbase_id'];
       
        $stmtAddEvent = $connection->prepare("UPDATE tblevent SET event_name=?, event_type=?, event_date=?, event_time=?, event_location=?, event_description=? WHERE event_id = ?");
        $stmtAddEvent->bind_param("ssssssi", $event_name, $event_type, $event_date, $event_time, $event_location, $event_description, $event_id);
        $stmtAddEvent->execute();
        $stmtAddEvent->close();
      
        header("Location: fanbase.php?fanbase_ID={$fanbase_id}#E-{$event_id}");
        exit();
    }
?>