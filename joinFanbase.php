<?php
    include("includes/api.php");

    $fanbaseID = $_POST["fanbaseID"];
    $accID = $_POST["fanbaseMember"];

    echo "accid: $accID <br>";
    echo "fanbaseid: $fanbaseID";
    
    $sqlCreate = "INSERT INTO tbluseraccount_fanbase (account_id, fanbase_id, date_joined)
    VALUES ('$accID', '$fanbaseID', NOW())";
    $resultCreate = mysqli_query($connection, $sqlCreate);

    //

    $sqlCreate = "INSERT INTO tblfanbase_member (acc_fanbase_id)
    VALUES ('$connection->insert_id')";
    $resultCreate = mysqli_query($connection, $sqlCreate);

    header("Location: fanbase.php?fanbase_ID={$fanbaseID}");
    exit();
?>

<!-- <div>
    you have now joined the fanbase!
</div> -->