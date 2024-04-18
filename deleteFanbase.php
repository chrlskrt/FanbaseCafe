<?php
    include ("includes/api.php");

    $fanbase_name = $_POST['fanbase'];

    $sqlDeleteFanbase = "DELETE FROM tblFanbase WHERE fanbase_name = '{$fanbase_name}'";
    $resultfanbase = mysqli_query($connection, $sqlDeleteFanbase);

    header("Location: index.php");
    exit();
?>