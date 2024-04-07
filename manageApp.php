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
            <div class="label" style="font-size: 4.5vw;"> NUMBER OF USERS <br>'." $usercount ".' </div>
            <div class="label" style="font-size: 4.5vw;"> NUMBER OF FANBASES <br>'." $fanbasecount ".' </div>
        </div>
    ';
?>

<div class="manageAppDiv" style="margin-bottom:10px; border-top: 2px black solid; border-bottom: 2px black solid;">
    <div class="manageAppDiv">
        <a class="btn label" id="createFanbaseDiv" style="font-size: 2.5vw; text-align:left">+ Create Fanbase</a>
        
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
        <div class="btn label" id="manageFanbasesDiv" style="font-size: 2.5vw; text-align:left">+ Manage Fanbases</div>
        
        <div style="display: flex; justify-content: center;" id="manageFanbasesTable">
            <?php
                echo displayFanbasesTable();
            ?>
        </div>
    </div>

    <div class="manageAppDiv">
        <div class="btn label" id="manageUsersDiv" style="font-size: 2.5vw; text-align:left">+ Manage Users</div>
        
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
    function displayFanbasesTable(){
        global $connection;

        $sqlfanbase = "SELECT * FROM tblfanbase";
        $resultfanbase = mysqli_query($connection, $sqlfanbase);
        
        $fanbaseArray = array();
        if ($resultfanbase){
            while ($row = $resultfanbase->fetch_assoc()) {
                $fanbaseArray[] = $row;
            } 

            $resultfanbase->free();
        }

        // print_r($fanbaseArray);

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

        foreach($fanbaseArray as $fanbase){
            $tableStr .= '
                <tr>
                    <th scope="row">'.$fanbase['fanbase_id'].'</td>
                    <td>'.$fanbase['fanbase_artist'].'</td>
                    <td>'.$fanbase['fanbase_name'].'</td>
                    <td>'.$fanbase['date_created'].'</td>
                    <td>'.$fanbase['fanbase_description'].'</td>
                    <td><a href="manageFanbase.php?fanbase_id='.$fanbase['fanbase_id'].'" class="btn btn-outline-success">Edit</a></td>
                </tr>
            ';
        }

        $tableStr .= '</tbody></table></div>';

        return $tableStr;
    }

    function displayUsersTable(){
        global $connection;

        $sqlUserAccs = "SELECT * FROM tbluseraccount";
        $resultUsers = mysqli_query($connection, $sqlUserAccs);
        
        $userArray = array();
        if ($resultUsers){
            while ($row = $resultUsers->fetch_assoc()) {
                $userArray[] = $row;
            } 

            $resultUsers->free();
        }

        // print_r($userArray);

        $newUserArray = array();

        foreach($userArray as $user){
            $sqlUser = "SELECT * FROM tbluserprofile WHERE user_id ='".$user['user_id']."'";
            $resultUser = mysqli_query($connection, $sqlUser);
            $rowUser = mysqli_fetch_array($resultUser);

            $user['user_id'] = $rowUser;
            // var_dump($user['user_id']['user_id']);

            // print_r($user);
            $newUserArray[] = $user;
 
       }

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
                        (($user['account_id'] != $current_user['account_id']) ?
                            '<form action="manageAppUser.php" method="post"><div class="flex-container" style="gap: 5px;">'.
                                    (($user['isSysAdmin'] == 0) ? 
                                    '<button class="btn btn-outline-success" type="submit" name="promoteUser" value="'.$user['user_id']['user_id'].'">Promote to <b>SYSTEM ADMIN</b></button>' 
                                : '<button class="btn btn-outline-success" type="submit" name="demoteUser" value="'.$user['user_id']['user_id'].'">Demote to <b>NORMAL USER</b></button>')
                            .'<button class="btn btn-danger" type="submit" name="deleteUserAcc" value="'.$user['account_id'].'">Delete User Account</button>
                            </div></form>' 
                        : '').'</td>
                </tr>
            ';
        }

        $tableStr .= '</tbody></table></div>';

        return $tableStr;
    }
?>