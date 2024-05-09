<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $fanbase_id = $_POST['fanbase_id'];

    if (isset($_POST['joinEvent'])){
        $event_id = $_POST['joinEvent'];

        $stmtJoinEvent = $connection->prepare("INSERT INTO tblevent_participant (event_id, account_id) VALUES (?, ?)");
        $stmtJoinEvent->bind_param('ii', $event_id, $current_user['account_id']);
        $stmtJoinEvent->execute();
        $stmtJoinEvent->close();

        header("Location: ../fanbase.php?fanbase_ID={$fanbase_id}");
        exit();
    }

    if (isset($_POST['leaveEvent'])){
        $event_id = $_POST['leaveEvent'];

        $stmtLeaveEvent = $connection->prepare("DELETE FROM tblevent_participant WHERE event_id=? AND account_id=?");
        $stmtLeaveEvent->bind_param('ii', $event_id, $current_user['account_id']);
        $stmtLeaveEvent->execute();
        $stmtLeaveEvent->close();

        header("Location: ../fanbase.php?fanbase_ID={$fanbase_id}");
        exit();
    }
?>