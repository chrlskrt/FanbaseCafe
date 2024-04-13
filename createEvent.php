<?php
    include ("includes/api.php");

    $event_name = $_POST['event_name'];
    $event_type = $_POST['event_type'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_location = $_POST['event_location'];
    $event_description = $_POST['event_description'];
    $fanbase_id = $_POST['fanbase_id'];
    $account_id = $current_user['account_id'];

    // check if that sort of event is already registered for that date
    $sqlEvent = "SELECT event_id FROM tblevent WHERE fanbase_id = '{$fanbase_id}' AND event_name = '{$event_name}' AND event_type = '{$event_type}' AND event_date = '{$event_date}'";
    
    $sqlERes = mysqli_query($connection, $sqlEvent);
    $sqlECount = mysqli_num_rows($sqlERes);

    if ($sqlECount == 0){
        $stmtAddEvent = $connection->prepare("INSERT INTO tblevent (account_id, fanbase_id, event_name, event_type, event_date, event_time, event_location, event_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtAddEvent->bind_param("iissssss", $account_id, $fanbase_id, $event_name, $event_type, $event_date, $event_time, $event_location, $event_description);
        // $sqlAddEvent = "INSERT INTO tblevent (account_id, fanbase_id, event_name, event_type, event_date, event_time, event_location, event_description)
        //                 VALUES ('{$account_id}', '{$fanbase_id}', '{$event_name}', '{$event_type}', '{$event_date}', '{$event_time}', '{$event_location}', {$event_description})";
        // mysqli_query($connection, $sqlAddEvent);

        $stmtAddEvent->execute();
        $stmtAddEvent->close();
    }

    header("Location: fanbase.php?fanbase_ID={$fanbase_id}");
    exit();
?>