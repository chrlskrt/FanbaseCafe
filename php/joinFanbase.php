<?php
    include ("../connect.php");
    include ("../includes/api.php");

    $fanbaseID = $_POST["fanbaseID"];
    $accID = $_POST["fanbaseMember"];

    echo "accid: $accID <br>";
    echo "fanbaseid: $fanbaseID";
    
    $sqlCheckIfMemberDataExists = "SELECT acc_fanbase_id FROM tbluseraccount_fanbase WHERE account_id = $accID AND fanbase_id = $fanbaseID";
    $resultCheckIfMemberDataExists = mysqli_query($connection, $sqlCheckIfMemberDataExists);

    if (mysqli_num_rows($resultCheckIfMemberDataExists) == 1){
        $sqlUpdate = "UPDATE tbluseraccount_fanbase SET isMember = 1 WHERE account_id = $accID AND fanbase_id = $fanbaseID";
        $resultUpdate = mysqli_query($connection, $sqlUpdate);
    } else {
        $sqlCreate = "INSERT INTO tbluseraccount_fanbase (account_id, fanbase_id, date_joined)
                      VALUES ('$accID', '$fanbaseID', NOW())";
        $resultCreate = mysqli_query($connection, $sqlCreate);
    }
    
    header("Location: ../fanbase3.php?fanbase_ID={$fanbaseID}");
    exit();
?>