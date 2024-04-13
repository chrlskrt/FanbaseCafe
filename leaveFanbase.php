<?php
    include("includes/api.php");

    $fanbaseID = $_POST["fanbaseID"];
    $accID = $_POST["leaveFanbaseMember"];
    echo "$accID <br>";
    echo "$fanbaseID";

    $sqlDelete = "DELETE FROM tbluseraccount_fanbase WHERE account_id = ? AND fanbase_id = ?";
    $stmt = $connection->prepare($sqlDelete);

    $stmt->bind_param("ii",$accID,$fanbaseID);
    $stmt->execute();

    $stmt->close();

    header("Location: fanbase.php?fanbase_ID={$fanbaseID}");
    exit();
?>

<!-- <div> left fanbase successfully </div> -->