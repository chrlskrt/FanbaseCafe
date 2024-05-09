<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $fanbase_name = $_POST['fanbase'];

    $sqlDeleteFanbase = "UPDATE tblFanbase SET isDeleted = 1 WHERE fanbase_name = '{$fanbase_name}'";
    $resultfanbase = mysqli_query($connection, $sqlDeleteFanbase);

    header("Location: ../index.php");
    exit();
?>