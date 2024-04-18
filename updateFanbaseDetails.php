<?php
    include ("includes/api.php");

    $fanbase = $_POST['fanbase'];
    $new_desc = $_POST['fanbase_description'];
    $new_date = $_POST['date_created'];

    var_dump($_POST);
    $stmtUpdateFanbase = $connection->prepare("UPDATE tblFanbase 
                                                SET fanbase_description = ? , date_created = ? 
                                                WHERE fanbase_name = ?");
    $stmtUpdateFanbase->bind_param("sss", $new_desc, $new_date, $fanbase);
    $stmtUpdateFanbase->execute();
    $stmtUpdateFanbase->close();
    
    header("Location: manageFanbase.php?fanbase={$fanbase}");
    exit();
?>