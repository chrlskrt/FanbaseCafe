<?php

/* manageFanbase.php */
function getMembersTable($fanbaseName){
    global $connection, $fanbase;

    // getting ALL data from tbluseraccount_fanbase
    $sqlFanbaseMember = "SELECT acc_fanbase_id, f.account_id, u.username, date_joined, isAdmin 
                         FROM tbluseraccount_fanbase as f, tbluseraccount as u 
                         WHERE f.account_id = u.account_id AND fanbase_id = {$fanbase['fanbase_id']} AND isMember = 1";

    $resultMembers = mysqli_query($connection, $sqlFanbaseMember);
    
    // creating an empty array that will hold the data from $resultUsers
    $membersArray = array();
    if ($resultMembers){
        // looping thru every user account entry sa table, then add sa array
        while ($row = $resultMembers->fetch_assoc()) {
            $membersArray[] = $row;
        } 

        $resultMembers->free();
    }

    // creating a new empty array, para ma store pud apil si user account
    $newMembersArray = array();

    // looping thru each account
    foreach($membersArray as $member){
       $newMembersArray[] = $member; // add to the new array
    }

    // creating the Members table
    $MembersTableStr = "<div style='display: flex; justify-content: center; border: none; font-size:2vw'>
                        MEMBERS
                <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>Acc_Fanbase_ID</th>
                            <th scope='col'>Account_ID</th>
                            <th scope='col'>Username</th>
                            <th scope='col'>Date Joined</th>
                            <th scope='col'>        </th>
                        </tr>
                    </thead>
                    <tbody>";

    // creating the Admins table
    $AdminsTableStr = "<div style='display: flex; justify-content: center; border:none; font-size:2vw'>
                        ADMINS
                <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>Acc_Fanbase_ID</th>
                            <th scope='col'>Account_ID</th>
                            <th scope='col'>Username</th>
                            <th scope='col'>Date Joined</th>
                            <th scope='col'>        </th>
                        </tr>
                    </thead>
                    <tbody>";

    global $current_user;

    // looping thru every member entry
    foreach($newMembersArray as $member){
        if ($member['isAdmin'] == 1){
            $AdminsTableStr .= '
                <tr>
                    <th scope="row">'.$member['acc_fanbase_id'].'</td>
                    <td>'.$member['account_id'].'</td>
                    <td>'.$member['username'].'</td>
                    <td>'.$member['date_joined'].'</td>
                    <td>
                        <form action="php/manageFanbaseMember.php" method="post">
                            <input type="hidden" name="fanbase_id" value="'.$fanbase['fanbase_id'].'">
                            <div class="flex-container" style="gap: 5px;">'.
                                (($member['account_id'] == $current_user['account_id']) ? 
                                    '<button class="btn btn-outline-success" type="submit" name="demoteUser" disabled>Demote to <b>MEMBER</b></button>
                                     <button class="btn btn-danger" type="submit" name="removeUser" disabled>Remove User</button>'
                                  : '<button class="btn btn-outline-success" type="submit" name="demoteUser" value="'.$member['acc_fanbase_id'].'">Demote to <b>MEMBER</b></button>
                                     <button class="btn btn-danger" type="submit" name="removeUser" value="'.$member['acc_fanbase_id'].'">Remove User</button>'
                                )
                            .'</div>
                        </form>
                    </td>
                </tr>
            ';
        } else {
            $MembersTableStr .= '
                <tr>
                    <th scope="row">'.$member['acc_fanbase_id'].'</td>
                    <td>'.$member['account_id'].'</td>
                    <td>'.$member['username'].'</td>
                    <td>'.$member['date_joined'].'</td>
                    <td>
                        <form action="php/manageFanbaseMember.php" method="post">
                            <input type="hidden" name="fanbase_id" value="'.$fanbase['fanbase_id'].'">
                            <div class="flex-container" style="gap: 5px;">
                                <button class="btn btn-outline-success" type="submit" name="promoteUser" value="'.$member['acc_fanbase_id'].'">Promote to <b>ADMIN</b></button>
                                <button class="btn btn-danger" type="submit" name="removeUser" value="'.$member['acc_fanbase_id'].'">Remove User</button>
                            </div>
                         </form>
                    </td>
                </tr>
            ';
        }
    }

    // admin request
    $sqlRequests = "SELECT adminrequest_id, r.account_id, username, date_requested 
                    FROM tblfanbase_adminrequest as r, tbluseraccount as u
                    WHERE r.account_id = u.account_id AND isRequested = 1 AND fanbase_id = {$fanbase['fanbase_id']}";
    $resultRequests = mysqli_query($connection, $sqlRequests);

    $requests = array();

    if ($resultRequests){
        while ($row = mysqli_fetch_array($resultRequests)){
           $requests[] = $row;
        }

        $resultRequests->free();
    }

    // creating the Requests table
    $RequestsTableStr = "<div style='display: flex; justify-content: center; border: none; font-size:2vw'>
                    Request to be Admin
                <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>Account_ID</th>
                            <th scope='col'>Username</th>
                            <th scope='col'>Date Requested</th>
                            <th scope='col'>        </th>
                        </tr>
                    </thead>
                    <tbody>";

    foreach($requests as $request){
        $RequestsTableStr .= '
            <tr>
                <th scope="row">'.$request['account_id'].'</td>
                <td>'.$request['username'].'</td>
                <td>'.$request['date_requested'].'</td>
                <td>
                    <form action="php/manageAdminRequest.php" method="post">
                        <input type="hidden" name="account_id" value="'.$request['account_id'].'">
                        <input type="hidden" name="fanbase_id" value="'.$fanbase['fanbase_id'].'">
                        <input type="hidden" name="fanbase_name" value="'.$fanbase['fanbase_name'].'">
                        <div class="flex-container" style="gap: 5px;">
                            <button class="btn btn-outline-success" type="submit" name="approveRequest" value="'.$request['adminrequest_id'].'">Approve</button>
                            <button class="btn btn-danger" type="submit" name="denyRequest" value="'.$request['adminrequest_id'].'">Deny</button>
                        </div>
                    </form>
                </td>
            </tr>
        ';
    }

    // REPORT

    // MOST POPULAR EVENT (most joined members)
    $RepEventTableStr = "
                <br> <div class='label'> FANBASE REPORT </div> <hr>
                <div style='display: flex; justify-content: center; border:none; font-size:2vw'>
                        MOST POPULAR EVENTS
                <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>Top</th>
                            <th scope='col'>Event_ID</th>
                            <th scope='col'>Event Name</th>
                            <th scope='col'>Number of Participants</th>
                        </tr>
                    </thead>
                    <tbody>";

    $sqlEvent = "SELECT tblevent.event_id, tblevent.event_name, COUNT(tblevent_participant.account_id) AS Participants 
                 FROM tblevent, tblevent_participant 
                 WHERE tblevent.fanbase_id = {$fanbase['fanbase_id']} AND tblevent.event_id = tblevent_participant.event_id 
                 GROUP BY tblevent.event_id 
                 ORDER BY Participants DESC";
    $resultEvent = mysqli_query($connection, $sqlEvent);
    $eventArray = array();

    if ($resultEvent){
        while ($row = $resultEvent->fetch_assoc()) {
            $eventArray[] = $row;
        } 
        $resultEvent->free();
    }

    $eventArray = array_slice($eventArray, 0, 5);

    $count = 1;
    foreach($eventArray as $event) {
        if($event['Participants'] >= 1) {
            $RepEventTableStr .= '
            <tr>
                <th scope="row">'.$count.'</td>
                <td>'.$event['event_id'].'</td>
                <td>'.$event['event_name'].'</td>
                <td>'.$event['Participants'].'</td>
            </tr>
            ';
            $count++;
        }
    }

    // // MOST INTERACTED POST (most replies)

    // $RepRepliedTableStr = "
    //             <div style='display: flex; justify-content: center; border:none; font-size:2vw'>
    //                     MOST INTERACTED POSTS
    //             <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
    //                 <thead>
    //                     <tr>
    //                         <th scope='col'>Top</th>
    //                         <th scope='col'>Username</th>
    //                         <th scope='col'>Post_ID</th>
    //                         <th scope='col'>Post</th>
    //                         <th scope='col'>Date</th>
    //                         <th scope='col'>Number of Replies</th>
    //                     </tr>
    //                 </thead>
    //             <tbody>";

    // $sqlPost = "SELECT tblpost.post_created, tblpost.post_text, tblpost.post_id, tbluseraccount.username, 
    // COUNT(DISTINCT tblreply.reply_id) as Replies FROM tblpost, tbluseraccount, tblreply WHERE tblpost.fanbase_id = {$fanbase['fanbase_id']} 
    // AND tblreply.post_id = tblpost.post_id AND tblpost.account_id = tbluseraccount.account_id GROUP BY tblpost.post_id 
    // ORDER BY Replies DESC";
    // $resultPost = mysqli_query($connection, $sqlPost);
    // $postArray = array();

    // if($resultPost) {
    //     while($row = $resultPost->fetch_assoc()) {
    //         $postArray[] = $row;
    //     }
    //     $resultPost->free();
    // }
    // $postArray = array_slice($postArray, 0, 5);

    // $count = 1;
    // foreach($postArray as $post) {
    //     if($post['Replies'] >= 1) {
    //         $RepRepliedTableStr .= '
    //         <tr>
    //             <th scope="row">'.$count.'</td>
    //             <td>'.$post['username'].'</td>
    //             <td>'.$post['post_id'].'</td>
    //             <td>'.$post['post_text'].'</td>
    //             <td>'.$post['post_created'].'</td>
    //             <td>'.$post['Replies'].'</td>
    //         </tr>
    //         ';
    //         $count++;
    //     }
    // }

    // // MOST ACTIVE USER (most posts)

    // $RepUserTableStr = "
    //             <div style='display: flex; justify-content: center; border:none; font-size:2vw'>
    //                     MOST ACTIVE USER
    //             <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
    //                 <thead>
    //                     <tr>
    //                         <th scope='col'>Top</th>
    //                         <th scope='col'>Username</th>
    //                         <th scope='col'>Date Joined</th>
    //                         <th scope='col'>Number of Posts</th>
    //                     </tr>
    //                 </thead>
    //             <tbody>";

    // $sqlUser = "SELECT tbluseraccount.username, tbluseraccount_fanbase.date_joined, COUNT(DISTINCT tblpost.post_id) 
    // as Posts FROM tbluseraccount, tbluseraccount_fanbase, tblpost WHERE tblpost.fanbase_id = {$fanbase['fanbase_id']} AND 
    // tblpost.account_id = tbluseraccount.account_id AND tblpost.fanbase_id = {$fanbase['fanbase_id']} GROUP BY tblpost.account_id 
    // ORDER BY Posts DESC";
    // $resultUser = mysqli_query($connection, $sqlUser);
    // $userArray = array();

    // if($resultUser) {
    //      while($row = $resultUser->fetch_assoc()) {
    //         $userArray[] = $row;
    //     }
    //     $resultUser->free();
    // }

    // $userArray = array_slice($userArray, 0, 5);

    // // var_dump($newUserArray);

    // $count = 1;
    // foreach($userArray as $user) {
    //     if($user['Posts'] >= 1) {
    //         $RepUserTableStr .= '
    //         <tr>
    //             <th scope="row">'.$count.'</td>
    //             <td>'.$user['username'].'</td>
    //             <td>'.$user['date_joined'].'</td>
    //             <td>'.$user['Posts'].'</td>
    //         </tr>
    //         ';
    //         $count++;
    //     }
    // }

    $AdminsTableStr .= '</tbody></table></div></div>';
    $MembersTableStr .= '</tbody></table></div></div>';
    $RequestsTableStr .= '</tbody></table></div></div>';
    $RepEventTableStr .= '</tbody></table></div></div>';
    // $RepRepliedTableStr .= '</tbody></table></div></div>';
    // $RepUserTableStr .= '</tbody></table></div></div>';

    $tableStr = $AdminsTableStr.$MembersTableStr.$RequestsTableStr.$RepEventTableStr;
    //$RepRepliedTableStr.$RepUserTableStr
    return $tableStr;
}