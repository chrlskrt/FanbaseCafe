<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $fanbase_id = $_POST['fanbase_id'];

    $sqlDeleteFanbase = "UPDATE tblFanbase SET isDeleted = 1 WHERE fanbase_id = '{$fanbase_id}'";
    $resultfanbase = mysqli_query($connection, $sqlDeleteFanbase);

    header("Location: ../index.php");
    exit();
?>