<?php
    include ("includes/api.php");
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
        }
    
        if (isset($_POST['demoteUser'])){
            echo ("DEMOTING USER ID: " . $_POST['demoteUser'] . '<br> in FANBASE: '. $fanbaseID);
            $acc_fanbase_id = $_POST['demoteUser'];
            // update isAdmin to 0
            $isAdmin = 0;
        }

        $sqlManageAdminStatus->bind_param('ii', $isAdmin, $acc_fanbase_id);
        $sqlManageAdminStatus->execute();
        $sqlManageAdminStatus->close();
    }

    if (isset($_POST['removeUser'])){
        echo ("REMOVING USER ID: " . $_POST['removeUser'] . '<br> in FANBASE: '. $fanbaseID);
        $acc_fanbase_id = $_POST['removeUser'];

        // delete from tbluseraccount_fanbase, same mechanism sa leave fanbase
        $sqlDelete = $connection->prepare("DELETE FROM tbluseraccount_fanbase WHERE acc_fanbase_id = ?");
        $sqlDelete->bind_param('i', $acc_fanbase_id);
        $sqlDelete->execute();
        $sqlDelete->close();
    }

    header("Location: manageFanbase.php?fanbase=$fanbase_name");
    exit();
?>