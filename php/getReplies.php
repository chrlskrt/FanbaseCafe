<?php
    include ("../connect.php");
    include("../includes/api.php");
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $post_id = $_POST['post_id'];

        $sqlRepliesQuery = "SELECT reply_id, post_id, r.account_id, username, reply_created, reply_text
                            FROM tblreply as r, tbluseraccount as u 
                            WHERE post_id = {$post_id} AND r.account_id = u.account_id";
        $resultReplies = mysqli_query($connection, $sqlRepliesQuery);

        $replyArr = array();

        if ($resultReplies){
            while ($row = mysqli_fetch_assoc($resultReplies)){
                $row['reply_created'] = date_format(date_create($row['reply_created']), "m.d H:i");
                $replyArr[] = $row;
            }

            $resultReplies -> free();
        } else {
            die("error fetching replies");
        }

        echo json_encode($replyArr, JSON_PRETTY_PRINT);        
    }
?>