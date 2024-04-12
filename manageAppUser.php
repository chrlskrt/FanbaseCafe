<?php
    include 'includes/api.php';
    $_SESSION['manageAppUser_data'] = $_POST;

    if (isset($_POST['promoteUser'])){
        // echo ("PROMOTING USER ID: " . $_POST['promoteUser']);
        $account_id = $_POST['promoteUser'];
        $sqlPromoteUser = "UPDATE tbluseraccount SET isSysAdmin = 1 WHERE account_id = {$account_id}";
        $resultPromoteUser = mysqli_query($connection, $sqlPromoteUser);

        if ($resultPromoteUser){
            header('Location: manageApp.php?promoteUser');
            exit();
        }
    }

    if (isset($_POST['demoteUser'])){
        // echo ("DEMOTING USER ID: " . $_POST['demoteUser']);
        $account_id = $_POST['demoteUser'];

        $sqlDemoteUser = "UPDATE tbluseraccount SET isSysAdmin = 0 WHERE account_id = {$account_id}";
        $resultDemoteUser = mysqli_query($connection, $sqlDemoteUser);

        if ($resultDemoteUser){
            header('Location: manageApp.php?demoteUser');
            exit();
        }
    }

    if (isset($_POST['deleteUserAcc'])){
        // echo ("DELETING USER ID: " . $_POST['deleteUserAcc']);
        $account_id = $_POST['deleteUserAcc'];
        $sqlDeleteUserAcc = "DELETE FROM tbluseraccount WHERE account_id={$account_id}";
        $resultDeleteUserAcc = mysqli_query($connection, $sqlDeleteUserAcc);

        if ($resultDeleteUserAcc){
            header('Location: manageApp.php?deleteUserAcc');
            exit();
        }
    }
?>