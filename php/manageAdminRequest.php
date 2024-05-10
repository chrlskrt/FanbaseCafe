<?php
    include('../includes/api.php');
    include('../connect.php');
    
    $reqAccount_id = $_POST['account_id'];
    $fanbase_id = $_POST['fanbase_id'];

    if (isset($_POST['approveRequest'])){
        $adminrequest_id = $_POST['approveRequest'];

        $stmt = $connection->prepare("UPDATE tblfanbase_adminrequest SET isRequested = 0 WHERE adminrequest_id = ?");
        $stmt->bind_param("i", $adminrequest_id);
        $stmt->execute();
        $stmt->close();

        $sqlAccFanbaseID = "SELECT acc_fanbase_id FROM tbluseraccount_fanbase WHERE account_id = $reqAccount_id AND fanbase_id = $fanbase_id";
        $acc_fanbase_id = mysqli_fetch_assoc(mysqli_query($connection, $sqlAccFanbaseID))['acc_fanbase_id'];

        $sqlUpdate = "UPDATE tbluseraccount_fanbase SET isAdmin = 1 WHERE acc_fanbase_id = {$acc_fanbase_id}";
        $res1 = mysqli_query($connection, $sqlUpdate);

        $sqlCheckIfAdmin = "SELECT fanbase_admin_id FROM tblfanbase_admin WHERE acc_fanbase_id = {$acc_fanbase_id}";
        $res = mysqli_query($connection, $sqlCheckIfAdmin);
        if (mysqli_num_rows($res) == 1){
            $sqlUpdate2 = "UPDATE tblfanbase_admin SET isDemoted = 0 WHERE acc_fanbase_id = {$acc_fanbase_id}";
            $res2 = mysqli_query($connection, $sqlUpdate2);
        } else {
            $sqlInsert = "INSERT INTO tblfanbase_admin (acc_fanbase_id, date_appointed) VALUES ('$acc_fanbase_id', NOW())";
            $res3 = mysqli_query($connection, $sqlInsert);
        }
    }

    if (isset($_POST['denyRequest'])){
        $adminrequest_id = $_POST['denyRequest'];

        $stmt = $connection->prepare("UPDATE tblfanbase_adminrequest SET isRequested = 0, isRejected = 1 WHERE adminrequest_id = ?");
        $stmt->bind_param("i", $adminrequest_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ../manageFanbase.php?fanbase=$fanbase_id");
    exit();
?>