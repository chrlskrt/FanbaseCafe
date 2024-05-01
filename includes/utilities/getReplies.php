<?php
    function getReplies($post_id, $fanbase_id){
        global $connection, $current_user;

        $sqlRepliesQuery = "SELECT * FROM tblreply WHERE post_id = {$post_id}";
        $resultReplies = mysqli_query($connection, $sqlRepliesQuery);

        $replyArr = array();

        if ($resultReplies){
            while ($row = mysqli_fetch_array($resultReplies)){
                $sqlReplyOwner = "SELECT account_id, username FROM tbluseraccount WHERE account_id = {$row['account_id']}";
                $resultReplyOwner = mysqli_fetch_array(mysqli_query($connection, $sqlReplyOwner));

                $row['reply_created'] = date_format(date_create($row['reply_created']), "m. d. H:i");
                $row['account_id'] = $resultReplyOwner;
                $replyArr[] = $row;
            }

            $resultReplies -> free();
        } else {
            return "";
        }

        $replies = "";

        foreach ($replyArr as $reply){
            $replies.= '<div style="display: flex; flex-direction: column;">
                            <div style="display: flex; width: 100%; justify-content: space-between;">
                                <div style="display:flex; gap:10px">
                                    <div style="display: flex; align-items: center">
                                        <img src="https://ui-avatars.com/api/?rounded=true&name=' . $reply['account_id']['username'] . '" alt="" style="height: 35; width:35">
                                    </div>
                                    <div style="display:flex; flex-direction:column; justify-content:center">
                                        <h5 style="margin-bottom:3px;">' . $reply['account_id']['username'] . '</h5>
                                        <p style="font-size: 10; color: gray; margin:0">' . $reply['reply_created'] . '</p>
                                    </div>
                                </div>'.
                                    (($reply['account_id']['account_id'] == $current_user['account_id']) ?
                                        '<div><form method="POST" action="deleteReply.php">
                                            <input type="hidden" name="fanbase_id" value="'.$fanbase_id.'">
                                            <input type="hidden" name="post_id" value="'.$reply['post_id'].'">
                                            <button type="submit" name="reply_id" value="'.$reply['reply_id'].'" class="btn btn-outline-light">🗑️</button>
                                        </form></div>'
                                        :
                                        ''
                                    )
                                .' 
                            </div>

                            <div style="margin-left: 45px">'.$reply['reply_text'].'</div>
                        </div>';
        }

        return $replies;
    }
?>