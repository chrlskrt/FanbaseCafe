<?php

/* manageApp.php */
function getFanbasesTable(){
    global $connection;

    // getting ALL data from tblfanbase
    $sqlfanbase = "SELECT * FROM tblfanbase";
    $resultfanbase = mysqli_query($connection, $sqlfanbase);
    
    // creating an empty array
    $fanbaseArray = array();

    if ($resultfanbase){
        /* query is a success
        /* looping thru every row of record sa tblfanbase */
        while ($row = $resultfanbase->fetch_assoc()) {
            /* $row = 1 fanbase entry
            /* iadd siya sa fanbase array */
            $fanbaseArray[] = $row;
        } 

        $resultfanbase->free(); // freeing result set
    }

    // creating the html table, gistore ra siya as string na iprint later on
    $tableStr = "<div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Artist</th>
                            <th scope='col'>Fanbase Name</th>
                            <th scope='col'>Date Created</th>
                            <th scope='col'>Fanbase Description</th>
                            <th scope='col'>        </th>
                        </tr>
                    </thead>
                    <tbody>";

    // looping thru every fanbase entry
    foreach($fanbaseArray as $fanbase){
        $tableStr .= '
            <tr>
                <th scope="row">'.$fanbase['fanbase_id'].'</td>
                <td>'.$fanbase['fanbase_artist'].'</td>
                <td>'.$fanbase['fanbase_name'].'</td>
                <td>'.$fanbase['date_created'].'</td>
                <td>'.$fanbase['fanbase_description'].'</td>
                <td><a href="manageFanbase.php?fanbase='.$fanbase['fanbase_id'].'" class="btn btn-outline-success">Edit</a></td>
            </tr>
        ';
    }

    $tableStr .= '</tbody></table></div>';

    return $tableStr;
}

function getUsersTable(){
    global $connection;

    // getting ALL data from tbluseraccount
    $sqlUserAccs = "SELECT * FROM tbluseraccount WHERE isDeleted = 0";
    $resultUsers = mysqli_query($connection, $sqlUserAccs);
    
    // creating an empty array that will hold the data from $resulyUsers
    $userArray = array();
    if ($resultUsers){
        // looping thru every user account entry sa table, then add sa array
        while ($row = $resultUsers->fetch_assoc()) {
            $userArray[] = $row;
        } 

        $resultUsers->free();
    }

    // creating a new empty array, para ma store pud apil si user profile
    $newUserArray = array();

    // looping thru each account
    foreach($userArray as $user){
        // getting the user's profile from tblprofile
        $sqlUser = "SELECT * FROM tbluserprofile WHERE user_id ='".$user['user_id']."'";
        $resultUser = mysqli_query($connection, $sqlUser);
        $rowUser = mysqli_fetch_array($resultUser);

        $user['user_id'] = $rowUser; // gi store ang user profile entry sa user_id sa user account
        
        $newUserArray[] = $user; // add to the new array
    }

    // creating the table
    $tableStr = "<div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>User_ID</th>
                            <th scope='col'>Account_ID</th>
                            <th scope='col'>Username</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>Birthdate</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>        </th>
                        </tr>
                    </thead>
                    <tbody>";

    global $current_user;

    // looping thru every user entry
    foreach($newUserArray as $user){
        $tableStr .= '
            <tr>
                <th scope="row">'.$user['user_id']['user_id'].'</td>
                <td>'.$user['account_id'].'</td>
                <td>'.$user['username'].'</td>
                <td>'.$user['user_id']['firstname'].' '.$user['user_id']['lastname'].'</td>
                <td>'.$user['user_id']['birthdate'].'</td>
                <td>'.$user['email_add'].'</td>
                <td>'.
                    // if ang current na user entry is ang current_user logged in, dili siya ka demote sa iyang self ug ka delete sa iyang account
                    (($user['account_id'] != $current_user['account_id']) ?
                        '<form action="php/manageAppUser.php" method="post" style="margin-bottom:0"><div class="flex-container" style="gap: 5px;">'.
                                // if the current user entry is a system_admin, ang option niya is demote to normal user
                                // if the current user entry is not a system_admin, ang option is promote to system admin
                                (($user['isSysAdmin'] == 0) ? 
                                '<button class="btn btn-outline-success" type="submit" name="promoteUser" value="'.$user['account_id'].'">Promote to <b>SYSTEM ADMIN</b></button>' 
                            : '<button class="btn btn-outline-success" type="submit" name="demoteUser" value="'.$user['account_id'].'">Demote to <b>NORMAL USER</b></button>')
                        .'<input type="hidden" name="username" value="'.$user['username'].'">
                        <button class="btn btn-danger" type="submit" name="deleteUserAcc" value="'.$user['account_id'].'">Delete User Account</button>
                        </div></form>' 
                    : '').'</td>
            </tr>
        ';
    }

    $tableStr .= '</tbody></table></div>';

    return $tableStr;
}

function getAppReports(){
    global $connection;

    // get top 3 fanbases with most members
    $sqlFanbase = "SELECT fanbase_name, count(acc_fanbase_id) as MemberCount 
                   FROM tblfanbase, tbluseraccount_fanbase 
                   WHERE tblfanbase.fanbase_id = tbluseraccount_fanbase.fanbase_id AND tblfanbase.isDeleted = 0
                   GROUP BY tblfanbase.fanbase_id 
                   ORDER BY MemberCount DESC";

    $result = mysqli_query($connection, $sqlFanbase);

    $topFanbasesArr = array();

    $fanbaseTopStr = "<div style='display: flex; flex-direction: column; justify-content: center; border: none; font-size:20px'>
                        TOP 3 FANBASE w MOST MEMBERS
                        <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                            <thead>
                                <tr>
                                    <th scope='col'>Top</th>
                                    <th scope='col'>Fanbase</th>
                                    <th scope='col'>Fans</th>
                            </thead>
                            <tbody>";

    if ($result){
        while($row = $result->fetch_assoc()){
            $topFanbasesArr[] = $row;
        }

        $result->free();

        $topFanbasesArr = array_splice($topFanbasesArr, 0, 3);

        $count = 1;
        foreach($topFanbasesArr as $fanbase){
            $fanbaseTopStr .= '
                <tr>
                    <th scope="row">'.$count.'</td>
                    <td>'.$fanbase['fanbase_name'].'</td>
                    <td>'.$fanbase['MemberCount'].'</td>
                </tr>
            ';

            $count++;
        }
    }

    $fanbaseTopStr .= '</tbody></table></div></div>';

    // // get top 3 fanbases with most posts 
    // $sqlMostPost = "SELECT fanbase_name, count(tblpost.fanbase_id) as PostCount 
    //                 FROM tblfanbase, tblpost 
    //                 WHERE tblfanbase.fanbase_id = tblpost.fanbase_id 
    //                 GROUP BY tblfanbase.fanbase_id";
    // $result = mysqli_query($connection, $sqlMostPost);

    // $topPostArr = array();

    // $postTopStr = "<div style='display: flex; flex-direction: column; justify-content: center; border: none; font-size:2vw'>
    //                 TOP 3 FANBASE w MOST POSTS
    //                 <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
    //                     <thead>
    //                         <tr>
    //                             <th scope='col'>Top</th>
    //                             <th scope='col'>Fanbase</th>
    //                             <th scope='col'>Number of Posts</th>
    //                     </thead>
    //                     <tbody>";

    // if ($result){
    //     while ($row = $result->fetch_assoc()){
    //         $topPostArr[] = $row;
    //     }

    //     $result->free();

    //     $topPostArr = array_splice($topPostArr, 0, 3);

    //     $count = 1;
    //     foreach($topPostArr as $fanbase){
    //         $postTopStr .= '
    //             <tr>
    //                 <th scope="row">'.$count.'</td>
    //                 <td>'.$fanbase['fanbase_name'].'</td>
    //                 <td>'.$fanbase['PostCount'].'</td>
    //             </tr>
    //         ';

    //         $count++;
    //     }
    // }

    // $postTopStr .= '</tbody></table></div></div>';
    // get events with type ""
    $sqlEvent = "SELECT event_id, fanbase_name, event_name, event_description 
                 FROM tblevent, tblfanbase 
                 WHERE tblevent.fanbase_id = tblfanbase.fanbase_id AND event_type = 'MEET & GREET'";
                 
    $result = mysqli_query($connection, $sqlEvent);

    $eventArr = array();

    $eventStr = "<div style='display: flex; flex-direction: column; justify-content: center; border: none; font-size:20px'>
                    EVENTS with type: meet & greet
                    <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                        <thead>
                            <tr>
                                <th scope='col'>Event ID</th>
                                <th scope='col'>Fanbase</th>
                                <th scope='col'>Event</th>
                                <th scope='col'>Event Description</th>
                        </thead>
                        <tbody>";

    if ($result){
        while ($row = $result->fetch_assoc()){
            $eventArr[] = $row;
        }

        $result->free();

        foreach($eventArr as $event){
            $eventStr .= '
                <tr>
                    <th scope="row">'.$event['event_id'].'</td>
                    <td>'.$event['fanbase_name'].'</td>
                    <td>'.$event['event_name'].'</td>
                    <td>'.$event['event_description'].'</td>
                </tr>
            ';
        }
    }

    $eventStr .= '</tbody></table></div></div>';

    // return $fanbaseTopStr.$postTopStr.$eventStr;
    return $fanbaseTopStr.$eventStr;
}