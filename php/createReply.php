<?php
    include ("../connect.php");
    include ("../includes/api.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
         // getting inputs of form submission
        $post_id = $_POST["post_id"];
        $account_id = $current_user['account_id'];
        // $fanbase_id = $_POST["fanbase_id"];
        $reply_created = date("Y-m-d H:i");
        $reply_text = $_POST['reply_text'];
        
        $stmtAddPost = $connection->prepare("INSERT INTO tblreply (post_id, account_id, reply_created, reply_text) VALUES (?, ?, ?, ?)");
        $stmtAddPost->bind_param("iiss", $post_id, $account_id, $reply_created, $reply_text);
        $stmtAddPost->execute();
        $reply_id = $stmtAddPost->insert_id;

        $stmtAddPost->close();

        $reply = array(
            "reply_id" => $reply_id,
            "post_id" => $_POST['post_id'],
            "fanbase_id" => $_POST['fanbase_id'],
            "account_id" => $current_user['account_id'],
            "username"  => $current_user['username'],
            "reply_created" => date_format(date_create(date("Y-m-d H:i")), "m. d. H:i"),
            "reply_text" => $_POST['reply_text']
        );

        echo json_encode($reply);
    }
?>