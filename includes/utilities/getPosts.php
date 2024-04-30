<?php
    // fanbase.php

    function getPosts($fanbase_id){
        global $connection, $current_user;

        // getting the member info of the current_user from tbluseraccount_fanbase table
        $sqlCurrFanbaseMember = "SELECT * FROM tbluseraccount_fanbase WHERE fanbase_id = {$fanbase_id} AND account_id = {$current_user['account_id']}";
        $resMem = mysqli_fetch_array(mysqli_query($connection, $sqlCurrFanbaseMember));
        $isFanbaseAdmin = $resMem['isAdmin'];

        // getting ALL posts for this fanbase from tblpost
        $sqlPosts = "SELECT * FROM tblpost WHERE fanbase_id = {$fanbase_id}";

        $resultPosts = mysqli_query($connection, $sqlPosts);

        // var_dump(mysqli_fetch_array($resultPosts));
        // creating an empty array
        $fanbasePostsArr = array();

        if ($resultPosts){
            // looping thru every post entry sa table, then add sa array
            while ($row = $resultPosts->fetch_assoc()) {
                $sqlPostOwner = "SELECT * from tbluseraccount WHERE account_id = {$row['account_id']}";
                $resPostOwner = mysqli_fetch_array(mysqli_query($connection, $sqlPostOwner));
                
                $row['post_created'] = date_format(date_create($row['post_created']), "m. d. H:i");
                $row['account_id'] = $resPostOwner;
                $fanbasePostsArr[] = $row;
            } 

            $resultPosts->free();
        }

        $posts = "";

        foreach($fanbasePostsArr as $post){
            $posts .= '
                <div class="post" style="padding:20px; background-color:white; border-radius:10px">
                    <div style="display: flex; width: 100%; justify-content: space-between; gap:10px;">
                        <div style="display:flex; gap:10px">
                            <div style="display: flex; align-items: center">
                                <img src="https://ui-avatars.com/api/?rounded=true&name=' . $post['account_id']['username'] . '" alt="" style="height: 50; width:50">
                            </div>
                            <div style="display:flex; flex-direction:column; justify-content:center">
                                <h4 style="margin-bottom:3px;">' . $post['account_id']['username'] . '</h4>
                                <p style="font-size: 12; color: gray; margin:0">' . $post['post_created'] . '</p>
                            </div>
                        </div>'.
                            (($post['account_id']['account_id'] == $current_user['account_id'] || $isFanbaseAdmin == 1) ?
                                '<div><form method="POST" action="deletePost.php">
                                    <input type="hidden" name="fanbase_id" value="'.$post['fanbase_id'].'">
                                    <button type="submit" name="post_id" value="'.$post['post_id'].'" class="btn btn-outline-light">🗑️</button>
                                </form></div>'
                                :
                                ''
                            )
                        .'
                    </div>

                    <div class="" style="display:flex; flex-direction:column; gap: 10px;">
                        <div style="font-size:24px">'.$post['post_text'].'</div>
                        <div role="button" class="btn btn-outline-light btnReply">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" style="color:gray" class="bi bi-chat" viewBox="0 0 20 20">
                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                            </svg>
                        </div>
                    </div>

                    <div class="Replies" style="display:flex; flex-direction:column; margin-left:90px; margin-top: 15px; gap:15px">
                        <form action="createReply.php" method="post" style="margin:0">
                            <div class="mb-3 from-group" style="display:flex; gap:10px"> 
                                <textarea class="form-control" name="post_text" id="reply_text" placeholder="Write something..." required></textarea>
                                <input type="hidden" name="fanbase_id" value="'.$post['fanbase_id'].'">
                                <button name="post_id" value="'.$post['post_id'].'" type="submit" role="button" class="btn btn-outline-dark">Reply</button>
                            </div>
                        </form>

                        <div class="ReplyDiv">'.
                            getReplies($post['post_id'])
                        .'</div>
                    </div>
                </div>
            ';
        }

        return $posts;
    }
?>