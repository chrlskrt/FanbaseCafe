<?php
    include ("includes/api.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
         // getting inputs of form submission
        $account_id = $current_user['account_id'];
        $fanbase_id = $_POST["fanbase_id"];
        // $post_created = date("M d Y, H:i");
        $post_created = date("Y-m-d");
        $post_text = $_POST['post_text'];
        
        $stmtAddPost = $connection->prepare("INSERT INTO tblpost (account_id, fanbase_id, post_created, post_text) VALUES (?, ?, ?, ?)");
        $stmtAddPost->bind_param("iiss", $account_id, $fanbase_id, $post_created, $post_text);
        $stmtAddPost->execute();
        $stmtAddPost->close();
        
        header("Location: fanbase.php?fanbase_ID={$fanbase_id}");
        exit();
    }
?>