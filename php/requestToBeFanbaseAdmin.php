<?php
    include ("../connect.php");
    include ("../includes/api.php");

    if (isset($_POST['request'])){
        $fanbase_id = $_POST['request'];

        // check if user has already requested before
        $sqlCheckRequest = "SELECT isRequested FROM tblfanbase_adminrequest WHERE fanbase_id = {$fanbase_id} AND account_id = {$current_user['account_id']}";
        $resultCheckRequest = mysqli_query($connection, $sqlCheckRequest);
        $date = date("Y-m-d");

        var_dump($resultCheckRequest);
        if (mysqli_num_rows($resultCheckRequest) == 1){
            $stmt = $connection->prepare("UPDATE tblfanbase_adminrequest SET isRequested = 1, date_requested = ?, isRejected = 0 WHERE account_id = ? AND fanbase_id = ?");
            $stmt->bind_param("sii", $date, $current_user['account_id'], $fanbase_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $connection->prepare("INSERT INTO tblfanbase_adminrequest (account_id, fanbase_id, date_requested) VALUES (?,?,?)");
            $stmt->bind_param("iis", $current_user['account_id'], $fanbase_id, $date);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: ../fanbase.php?fanbase_ID={$fanbase_id}");
        exit();
    }

    if (isset($_POST['cancelrequest'])){
        $fanbase_id = $_POST['cancelrequest'];
        $stmt = $connection->prepare("UPDATE tblfanbase_adminrequest SET isRequested = 0 WHERE account_id = ? AND fanbase_id = ?");
        $stmt->bind_param("ii", $current_user['account_id'], $fanbase_id);
        $stmt->execute();
        $stmt->close();

        header("Location: ../fanbase.php?fanbase_ID={$fanbase_id}");
        exit();
    }
?>