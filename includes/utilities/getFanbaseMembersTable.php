<?php

/* manageFanbase.php */
function getMembersTable($fanbaseName){
    global $connection, $fanbase;

    // getting ALL data from tbluseraccount_fanbase
    $sqlFanbaseMember = "SELECT * FROM tbluseraccount_fanbase WHERE fanbase_id = {$fanbase['fanbase_id']}";
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
        // getting the member's account from tblaccount
        $sqlMember = "SELECT * FROM tbluseraccount WHERE account_id = {$member['account_id']}";
        $resultMember = mysqli_query($connection, $sqlMember);
        $rowMember = mysqli_fetch_array($resultMember);

        $member['account_id'] = $rowMember; // gi store ang user profile entry sa user_id sa user account
        
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
                    <td>'.$member['account_id']['account_id'].'</td>
                    <td>'.$member['account_id']['username'].'</td>
                    <td>'.$member['date_joined'].'</td>
                    <td>
                        <form action="manageFanbaseMember.php" method="post">
                            <input type="hidden" name="fanbase_id" value="'.$fanbase['fanbase_id'].'">
                            <div class="flex-container" style="gap: 5px;">'.
                                (($member['account_id']['account_id'] == $current_user['account_id']) ? 
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
                    <td>'.$member['account_id']['account_id'].'</td>
                    <td>'.$member['account_id']['username'].'</td>
                    <td>'.$member['date_joined'].'</td>
                    <td>
                        <form action="manageFanbaseMember.php" method="post">
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

    $AdminsTableStr .= '</tbody></table></div></div>';

    $MembersTableStr .= '</tbody></table></div></div>';

    $tableStr = $AdminsTableStr.$MembersTableStr;
    return $tableStr;
}