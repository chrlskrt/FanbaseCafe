<?php
    // fanbase.php

    function getPosts($fanbase_id){
        global $connection, $current_user;

        // getting the member info of the current_user from tbluseraccount_fanbase table
        $sqlCurrFanbaseMember = "SELECT isAdmin FROM tbluseraccount_fanbase WHERE fanbase_id = {$fanbase_id} AND account_id = {$current_user['account_id']}";
        $resMem = mysqli_fetch_array(mysqli_query($connection, $sqlCurrFanbaseMember));
        $isFanbaseAdmin = $resMem['isAdmin'];

        // getting ALL posts for this fanbase from tblpost
        $sqlPosts = "SELECT post_id, p.account_id, username as postOwner, fanbase_id, post_created, post_text 
                     FROM tblpost as p , tbluseraccount as u
                     WHERE p.account_id = u.account_id AND fanbase_id = {$fanbase_id}";
        $resultPosts = mysqli_query($connection, $sqlPosts);

        // var_dump(mysqli_fetch_array($resultPosts));
        // creating an empty array
        $fanbasePostsArr = array();

        if ($resultPosts){
            // looping thru every post entry sa table, then add sa array
            while ($row = $resultPosts->fetch_assoc()) {
                $row['post_created'] = date_format(date_create($row['post_created']), "m. d. H:i");

                $sqlReplyCount = "SELECT count(reply_id) as replyCount 
                                  FROM tblreply as r, tblpost as p
                                  WHERE r.post_id = p.post_id AND p.post_id = {$row['post_id']}";
                $replyCount = mysqli_fetch_assoc(mysqli_query($connection, $sqlReplyCount))['replyCount'];

                $row['replyCount'] = $replyCount;
                $fanbasePostsArr[] = $row;
            } 

            $resultPosts->free();
        }

        $posts = "";

        foreach($fanbasePostsArr as $post){
            $posts .= '
                <div class="post" id="post'.$post['post_id'].'">
                    <section style="width:100%; display: flex;justify-content: space-between; gap:10px;align-items:flex-start">
                        <section>
                            <div style="display: flex; flex-direction:column; gap:10px;">
                                <div style="display:flex; gap:10px">
                                    <div style="display: flex; align-items: center">
                                        <img src="https://ui-avatars.com/api/?rounded=true&name=' . $post['postOwner'] . '" alt="" style="height: 50; width:50">
                                    </div>
                                    <div style="display:flex; flex-direction:column; justify-content:center">
                                        <h4 style="margin-bottom:3px;">' . $post['postOwner'] . '</h4>
                                        <p style="font-size: 12; color: gray; margin:0">' . $post['post_created'] . '</p>
                                    </div>
                                </div>
                                <div style="max-width:50vw; margin-top:10px;font-size:20px; overflow-wrap: break-word">'.$post['post_text'].'</div>
                            </div>
                        </section>
                        '.
                            (($post['account_id'] == $current_user['account_id'] || $isFanbaseAdmin == 1) ?
                                '
                                    <button type="button" name="post_id" data-bs-toggle="modal" value="'.$post['post_id'].'" class="btn btn-outline-light btnDeletePost">🗑️</button>
                                '
                                :
                                ''
                            )
                        .'
                    </section>

                    <div role="button" class="btn btnReply" value="'.$post['post_id'].'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" style="color:gray" class="bi bi-chat" viewBox="0 0 20 20" value="'.$post['post_id'].'">
                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                        </svg>'.
                        (($post['replyCount'] > 0) ? 
                            ''.$post["replyCount"].''
                            : ''
                        )
                    .'</div>

                    <section class="ReplyDiv" style="width:100%;">
                        <div style="display:flex; width:100%; flex-direction:column-reverse;gap:10px">'.''
                            // getReplies($post['post_id'], $post['fanbase_id'])
                        .'</div>
                    </section>
                </div>
            ';
        }

        return $posts;
    }
?>
