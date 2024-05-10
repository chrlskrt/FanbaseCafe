<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $fanbase_id = $_POST['fanbase_id'];
    $new_desc = $_POST['fanbase_description'];
    $new_date = $_POST['date_created'];

    var_dump($_POST);
    $stmtUpdateFanbase = $connection->prepare("UPDATE tblFanbase 
                                                SET fanbase_description = ? , date_created = ? 
                                                WHERE fanbase_id = ?");
    $stmtUpdateFanbase->bind_param("sss", $new_desc, $new_date, $fanbase_id);
    $stmtUpdateFanbase->execute();
    $stmtUpdateFanbase->close();
    
    header("Location: ../manageFanbase.php?fanbase={$fanbase_id}");
    exit();
?>