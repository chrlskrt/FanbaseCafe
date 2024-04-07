<?php
    include("includes/header.php");

    $fanbaseID = $_GET['fanbase_id'];
    echo $fanbaseID;

    $sqlFanbase = "SELECT * FROM tblFanbase WHERE fanbase_id='".$fanbaseID."'";
    $resultFanbase = $connection->query($sqlFanbase);
    $fanbase = mysqli_fetch_array($resultFanbase);

    var_dump($fanbase);
?>