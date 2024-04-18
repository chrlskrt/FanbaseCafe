<?php
    include("includes/header.php");

    $fanbaseName = $_GET['fanbase'];

    $sqlFanbase = "SELECT * FROM tblFanbase WHERE fanbase_name='".$fanbaseName."'";
    $resultFanbase = $connection->query($sqlFanbase);
    $fanbase = mysqli_fetch_array($resultFanbase);

    // var_dump($fanbase);
?>
<script src="js/manageFanbase.js"></script>
<!-- <h5 style="font-size:4vw">FANBASE SETTINGS</h5> -->
<div class="manageFanbaseDiv" style="gap:5px;">
    <div class="label" style="font-size: 6vw;"><?php echo ($fanbase['fanbase_artist']) ?></div>
    <div class="label" style="font-size: 5vw; font-weight:unset"><?php echo ($fanbase['fanbase_name']) ?></div>
    
    <div class="manageFanbaseDiv" id="displayFanbaseDetailsDiv">
        <div class="label" style="font-weight: unset">Date founded: <br><b><?php echo ($fanbase['date_created']) ?></b></div>
        <div class="label" style="font-weight: unset">Description: <br><b><i>"<?php echo ($fanbase['fanbase_description']) ?>"</i></b></div>
        <button style="align-self: end;" type="button" class="btn btn-light" id="edit">Edit details</button>
    </div>

    <div class="manageFanbaseDiv" id="editFanbaseDetailsDiv">
        <form action="updateFanbaseDetails.php" method="post">
            <div class="formsch">
                <div class="form-group" > 
                    <div class="label" style="font-weight:unset; font-size: 3vw;">Date founded:</div>
                    <input type="date" class="form-control" id="date_created" name="date_created" value="<?php echo ($fanbase['date_created']) ?>" required>
                </div>
                <div class="form-group" style="margin-top:2vw;">
                    <div class="label" style="font-weight:unset; font-size: 3vw;">Description:</div>
                    <textarea class="form-control" name="fanbase_description" id="fanbase_description" required><?php echo ($fanbase['fanbase_description']) ?></textarea>
                </div>
                <div style="display:flex; justify-content:space-between">
                    <button type="button" class="btn btn-warning" id="cancelEdit">Cancel Edit</button>
                    <button id="btnUpdateFanbaseDetails" value="<?php echo $fanbaseName ?>" name="fanbase" type="submit" role="button" class="btn btn-success">Update Details</button>
                </div>
            </div>
        </form>
        <form action="deleteFanbase.php" method="POST">
            <button id="btnDeleteFanbase" value="<?php echo $fanbaseName ?>" name="fanbase" type="submit" role="button" class="btn btn-outline-danger">Delete Fanbase</button>
        </form>
    </div>

    <div class="manageFanbaseDiv">
        <div class="btn label" id="manageMembersDiv" style="font-size: 3vw; text-align:left; font-weight:unset">+ Manage Fanbase MEMBERS</div>
        <?php
            echo displayMembersTable();
        ?>
    </div>
</div>

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Charlene Repuesto and Angel Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>


<?php
    function displayMembersTable(){
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
?>