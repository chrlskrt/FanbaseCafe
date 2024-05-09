<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $firstname = $_POST['new_fname'];
    $lastname = $_POST['new_lname'];
    $birthday = $_POST['new_bday'];

    var_dump($_POST);
    $stmtUpdateFanbase = $connection->prepare("UPDATE tbluserprofile 
                                                SET firstname = ?, lastname = ?, birthdate = ?
                                                WHERE user_id = ?");
    $stmtUpdateFanbase->bind_param("sssi", $firstname, $lastname, $birthday, $current_user['user_id']);
    $stmtUpdateFanbase->execute();
    $stmtUpdateFanbase->close();
    
    header("Location: ../profile.php");
    exit();
?>