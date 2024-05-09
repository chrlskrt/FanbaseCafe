<?php

/* manageApp.php */
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