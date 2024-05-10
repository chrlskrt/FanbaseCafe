<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $fanbaseID = $_POST['fanbase_id'];

    $sqlFanbase = "SELECT fanbase_name FROM tblfanbase WHERE fanbase_id = $fanbaseID";
    $resultFanbase = mysqli_fetch_assoc(mysqli_query($connection, $sqlFanbase));

    $fanbase_name = $resultFanbase['fanbase_name'];

    if (isset($_POST['promoteUser']) || isset($_POST['demoteUser'])){
        $sqlManageAdminStatus = $connection->prepare("UPDATE tbluseraccount_fanbase SET isAdmin = ? WHERE acc_fanbase_id=?");

        if (isset($_POST['promoteUser'])){
            echo ("PROMOTING USER ID: " . $_POST['promoteUser'] . '<br> in FANBASE: '. $fanbaseID);
            $acc_fanbase_id = $_POST['promoteUser'];
            // update isAdmin to 1
            $isAdmin = 1;

            $sqlCheckIfAdmin = "SELECT fanbase_admin_id FROM tblfanbase_admin WHERE acc_fanbase_id = {$acc_fanbase_id}";
            $res = mysqli_query($connection, $sqlCheckIfAdmin);

            if ($res){
                $sqlUpdate2 = "UPDATE tblfanbase_admin SET isDemoted = 0 WHERE acc_fanbase_id = {$acc_fanbase_id}";
                $res2 = mysqli_query($connection, $sqlUpdate2);
            } else {
                $sqlInsert = "INSERT INTO tblfanbase_admin (acc_fanbase_id, date_appointed) VALUES ('$acc_fanbase_id', NOW())";
                $res3 = mysqli_query($connection, $sqlInsert);
            }
        }
    
        if (isset($_POST['demoteUser'])){
            echo ("DEMOTING USER ID: " . $_POST['demoteUser'] . '<br> in FANBASE: '. $fanbaseID);
            $acc_fanbase_id = $_POST['demoteUser'];
            // update isAdmin to 0
            $isAdmin = 0;

            $sqlUpdate2 = "UPDATE tblfanbase_admin SET isDemoted = 1 WHERE acc_fanbase_id = {$acc_fanbase_id}";
            $res2 = mysqli_query($connection, $sqlUpdate2);
        }

        $sqlManageAdminStatus->bind_param('ii', $isAdmin, $acc_fanbase_id);
        $sqlManageAdminStatus->execute();
        $sqlManageAdminStatus->close();
    }

    if (isset($_POST['removeUser'])){
        echo ("REMOVING USER ID: " . $_POST['removeUser'] . '<br> in FANBASE: '. $fanbaseID);
        $acc_fanbase_id = $_POST['removeUser'];

        // delete from tbluseraccount_fanbase, same mechanism sa leave fanbase
        $sqlDelete = $connection->prepare("UPDATE tbluseraccount_fanbase SET isMember = 0 WHERE acc_fanbase_id = ?");
        $sqlDelete->bind_param('i', $acc_fanbase_id);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    header("Location: ../manageFanbase.php?fanbase=$fanbase_name");
    exit();
?>