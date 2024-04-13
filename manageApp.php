<?php
    include("includes/header.php");
?>

<script src="js/manageApp.js"></script>

<?php
    $sqluser = "SELECT user_id FROM tbluseraccount";
    $sqlfanbase = "SELECT fanbase_id FROM tblfanbase";
    
    $resultuser = $connection->query($sqluser);
    $resultfanbase = $connection->query($sqlfanbase);
    
    $usercount = mysqli_num_rows($resultuser);
    $fanbasecount = mysqli_num_rows($resultfanbase);

    echo '
        <div class="flex-container" style="flex:none; padding: 30px">
            <div class="label" style="font-size: 5vw;"> NUMBER OF USERS <br>'." $usercount ".' </div>
            <div class="label" style="font-size: 5vw;"> NUMBER OF FANBASES <br>'." $fanbasecount ".' </div>
        </div>
    ';
?>

<div class="manageAppDiv" style="margin-bottom:10px; border-top: 2px black solid; border-bottom: 2px black solid;">
    <div class="manageAppDiv">
        <a class="btn label" id="createFanbaseDiv" style="font-size: 4vw; text-align:left">+ Create Fanbase</a>
        
        <div style="display: flex; justify-content: center;" id="createFanbaseForm">
            <form action="createFanbase.php" method="post">
                <div class="formsch">
                    <div class="form-floating mb-3"> 
                        <input type="text" class="form-control" name="fanbase_name" id="fanbase_name" placeholder="Enter fanbase name..." required>
                        <label for="fanbase_name">Fanbase Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="fanbase_artist" id="fanbase_artist" placeholder="Enter artist..." required>
                        <label for="fanbase_artist">Artist</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="fanbase_description" id="fanbase_description" placeholder="Enter fanbase description..." required></textarea>
                        <label for="fanbase_description">Fanbase Description</label>
                    </div>
                    <button id="btnCreateFanbase" value="1" type="submit" role="button" class="btn btn-outline-dark btn-lg btn-block">Create Fanbase</button>
                </div>
            </form>
        </div>
    </div>

    <div class="manageAppDiv" style="border-bottom: 2px black solid; border-top: 2px black solid;">
        <div class="btn label" id="manageFanbasesDiv" style="font-size: 4vw; text-align:left">+ Manage Fanbases</div>
        
        <div style="display: flex; justify-content: center;" id="manageFanbasesTable">
            <?php
                echo displayFanbasesTable();
            ?>
        </div>
    </div>

    <div class="manageAppDiv">
        <div class="btn label" id="manageUsersDiv" style="font-size: 4vw; text-align:left">+ Manage Users</div>
        
        <div style="display: flex; justify-content: center;" id="manageUsersTable">
            <?php
                echo displayUsersTable();
            ?>
        </div>
    </div>
</div>

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Charlene Repuesto
            <br>
            BSCS 2
        </a>
    </nav>
</footer>

<!-- MODALS -->
<div class="modal fade" tabindex="-1" role="dialog" id="fArtistErrorModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Whoops </h5>
      </div>
      <div class="modal-body">
        <p>There's an existing fanbase for the artist, <b><?php echo $_SESSION['createFanbase_data']['fanbase_artist'] ?></b>, already.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="fNameErrorModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Whoops </h5>
      </div>
      <div class="modal-body">
        <p>There's an existing fanbase with that name already.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="createFanbaseSuccessModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Success! </h5>
      </div>
      <div class="modal-body">
        <p>The fanbase, <b><?php echo $_SESSION['createFanbase_data']['fanbase_name'] ?></b>, for the artist, <b><?php echo $_SESSION['createFanbase_data']['fanbase_artist'] ?></b>, is created successfully!! Congratulations!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="promoteUserModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Success! </h5>
      </div>
      <div class="modal-body">
        <p>User, <b><?php echo $_SESSION['manageAppUser_data']['username'] ?></b>, is successfully promoted to <b>Sys_Admin</b>!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="demoteUserModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Success! </h5>
      </div>
      <div class="modal-body">
        <p>User, <b><?php echo $_SESSION['manageAppUser_data']['username'] ?></b>, is successfully demoted to an <b>ordinary user</b>!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="deleteUserAccountModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Success!</h5>
      </div>
      <div class="modal-body">
        <p>Account, <b><?php echo $_SESSION['manageAppUser_data']['username'] ?></b>, is successfully deleted from the system!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
    if (isset($_GET['artistFanbase_exists'])){
        echo "<script language = 'javascript'>
            $(function(){
                $('#createFanbaseForm').show();
                // $('#fanbase_name').val('".$_SESSION['createFanbase_data']['fanbase_name']."');
                // $('#fanbase_description').val('".$_SESSION['createFanbase_data']['fanbase_description']."');
                $('#fArtistErrorModal').modal('show');
            })
        </script>";
    }

    if (isset($_GET['fanbaseName_exists'])){
        echo "<script language = 'javascript'>
                    $(function(){
                        $('#createFanbaseForm').show();
                        $('#fanbase_artist').val('".$_SESSION['createFanbase_data']['fanbase_artist']."');
                        $('#fanbase_description').val('".$_SESSION['createFanbase_data']['fanbase_description']."');
                        $('#fNameErrorModal').modal('show');
                    })
                </script>";
    }

    if (isset($_GET['fanbaseCreate_success'])){
        echo "<script language = 'javascript'>
                    $(function(){
                        $('#createFanbaseSuccessModal').modal('show');
                    })
                </script>";
    }

    if (isset($_GET['promoteUser'])){
        echo "<script language = 'javascript'>
                    $(function(){
                        $('#manageUsersTable').show();
                        $('#promoteUserModal').modal('show');
                    })
                </script>";
    }

    if (isset($_GET['demoteUser'])){
        echo "<script language = 'javascript'>
                    $(function(){
                        $('#manageUsersTable').show();
                        $('#demoteUserModal').modal('show');
                    })
                </script>";
    }

    if (isset($_GET['deleteUserAcc'])){
      echo "<script language = 'javascript'>
                $(function(){
                    $('#manageUsersTable').show();
                    $('#deleteUserAccountModal').modal('show');
                })
            </script>";
     }

    function displayFanbasesTable(){
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
                    <td><a href="manageFanbase.php?fanbase='.$fanbase['fanbase_name'].'" class="btn btn-outline-success">Edit</a></td>
                </tr>
            ';
        }

        $tableStr .= '</tbody></table></div>';

        return $tableStr;
    }

    function displayUsersTable(){
        global $connection;

        // getting ALL data from tbluseraccount
        $sqlUserAccs = "SELECT * FROM tbluseraccount";
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
                            '<form action="manageAppUser.php" method="post" style="margin-bottom:0"><div class="flex-container" style="gap: 5px;">'.
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
?>