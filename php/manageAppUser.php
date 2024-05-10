<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $_SESSION['manageAppUser_data'] = $_POST;

    if (isset($_POST['promoteUser'])){
        // echo ("PROMOTING USER ID: " . $_POST['promoteUser']);
        $account_id = $_POST['promoteUser'];
        $sqlPromoteUser = "UPDATE tbluseraccount SET isSysAdmin = 1 WHERE account_id = {$account_id}";
        $resultPromoteUser = mysqli_query($connection, $sqlPromoteUser);

        $checkUserSysAdminStat = "SELECT sysAdmin_id FROM tbluseraccount_sysadmin WHERE account_id = {$account_id}";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $checkUserSysAdminStat));

        if (!$result){
            $sqlInsert = "INSERT INTO tbluseraccount_sysadmin (account_id, date_appointed) VALUES ('$account_id', NOW())";
            $res = mysqli_query($connection, $sqlInsert);
        } else {
            $sqlUpdate = "UPDATE tbluseraccount_sysadmin SET isDemoted = 0, date_appointed = NOW() WHERE account_id = {$account_id}";
            $res = mysqli_query($connection, $sqlUpdate);
        }

        if ($resultPromoteUser){
            header('Location: ../manageApp.php?promoteUser');
            exit();
        }
    }

    if (isset($_POST['demoteUser'])){
        // echo ("DEMOTING USER ID: " . $_POST['demoteUser']);
        $account_id = $_POST['demoteUser'];

        $sqlDemoteUser = "UPDATE tbluseraccount SET isSysAdmin = 0 WHERE account_id = {$account_id}";
        $resultDemoteUser = mysqli_query($connection, $sqlDemoteUser);

        $sqlDemoteUser = "UPDATE tbluseraccount_sysAdmin SET isDemoted = 1 WHERE account_id = {$account_id}";
        $resultDemoteUser = mysqli_query($connection, $sqlDemoteUser);

        if ($resultDemoteUser){
            header('Location: ../manageApp.php?demoteUser');
            exit();
        }
    }

    if (isset($_POST['deleteUserAcc'])){
        // echo ("DELETING USER ID: " . $_POST['deleteUserAcc']);
        $account_id = $_POST['deleteUserAcc'];
        $sqlDeleteUserAcc = "UPDATE tbluseraccount SET isDeleted = 1 WHERE account_id={$account_id}";
        $resultDeleteUserAcc = mysqli_query($connection, $sqlDeleteUserAcc);

        if ($resultDeleteUserAcc){
            header('Location: ../manageApp.php?deleteUserAcc');
            exit();
        }
    }
?>