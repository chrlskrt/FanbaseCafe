<?php
    include("includes/header.php");

    
    // echo "Name: ". $current_user['username'];
    $sql = "SELECT * FROM tbluserprofile WHERE user_id = {$current_user['user_id']}";
    $result = $connection->query($sql);
    
    $sqlFanbase = "SELECT * FROM tbluseraccount_fanbase WHERE account_id = {$current_user['account_id']}";
    $resultFanbase = $connection->query($sqlFanbase);

    // $sqluserFan = "SELECT * FROM tblfanbase WHERE fanbase_id = {$current_user['fanbase_id']}";
    // $resultUserFan = $connection->query($sqluserFan);

    $userProf = mysqli_fetch_array($result);
    // var_dump($userProf);

    // echo $userProf['firstname']. "<br>" .$userProf['birthdate'];
?>

<script src="js/profile.js"></script>

<div class="profileBG" style="background-image: url('images/profileBG2.png');">
<div class="announcement-container"></div>

<!-- MAIN PROFILE DIV -->
<div class="profile-container" id="displayProfile">
    <div class="profile-details-container" style="width:40%;">
        <img src="images/account.png" class="profile-icon-container">
        <div class="label" style="text-align:center;overflow-wrap:break-word;"> <?php echo $current_user['username'] ?> </div>
        <div class="text" style="color:gray; font-size: 16px;">
            <?php echo $current_user['account_id'] ?> 
        </div>

        <div style="flex-direction:column;overflow-wrap:break-word;">
            <div class="text" style="padding:5px;"> 
                <?php echo "Name: " .$userProf['firstname'] ?> 
                <?php echo $userProf['lastname'] ?> 
            </div>

            <div class="text" style="padding:5px;">
                <?php echo "Birthday: " .$userProf['birthdate'] ?> 
            </div>
        </div>

        <div style="padding:20px; align-items: center;margin-bottom:auto; margin-top:auto;">
            <button type="button" style="margin: 10px;" class="btn btn-dark" id="btnUpdateProf">Update Profile</button>
            <button class="btn btn-outline-danger" style="margin: 10px;" id="btnDeleteAccount"> Delete Account </button>
        </div>
    </div>
    <img src="images/profileBG.png" style="height:600px; width:60%; object-fit:cover;">

</div>

<!-- EDIT PROFILE DIV -->
<div class="profile-container" id="editProfile">
    <div class="profile-details-container" style="width:40%;">
        <img src="images/account.png" class="profile-icon-container">
        <div class="label" style="text-align:center;overflow-wrap:break-word;"> <?php echo $current_user['username'] ?> </div>

        <div>
            <?php
                $stmtUpdateFanbase = "SELECT firstname, lastname, birthdate FROM tbluserprofile WHERE user_id = {$current_user['user_id']}";
                
                $result = mysqli_query($connection,$stmtUpdateFanbase);
                $profileArray = mysqli_fetch_array($result);

                $old_firstname = $profileArray['firstname'];
                $old_lastname = $profileArray['lastname'];
                $old_birthdate = $profileArray['birthdate'];
            ?>
            <form action="php/updateProfileDetails.php" method="post">
                    <div class="form-group" > 
                        <div class="text"> First Name:</div>
                        <input class="form-control" style="height:50px;" id="new_fname" name="new_fname" value="<?php echo $old_firstname?>"> </input>
                        <div class="text">Last Name: </div>
                        <input class="form-control" name="new_lname" id="new_lname" value="<?php echo $old_lastname?>"> </input>
                        <div class="text"> Birthday: </div>
                        <input type="date" class="form-control" name="new_bday" id="new_bday" value="<?php echo $old_birthdate?>"> </input>
                    </div>
                    
                    <br>

                    <div style="padding:20px; align-items: center;margin-bottom:auto; margin-top:auto;">
                        <button id="btnUpdateProf" style="margin: 10px;" value="1" type="submit" role="button" class="btn btn-dark">Update </button>
                        <button id="cancelEditProf" style="margin: 10px;" role="button" class="btn btn-outline-danger" >Cancel </button>
                    </div>
            </form>
        </div>

    </div>
    <img src="images/profileBG.png" style="height:600px; width:60%; object-fit:cover;">

</div>

<!-- MODAL DELETE ACCOUNT -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteAccountModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Account</h5>
      </div>
      <div class="modal-body">
        <p> Are you sure? This action cannot be undone! </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
        <a role="button" href="deleteAccount.php" id="btnDeleteConfirm" class="btn btn-danger"> Delete </a>
      </div>
    </div>
  </div>
</div>

</div>

<footer>
    <nav class="navbar" style="background-color:#261a3a;">
        <a class="navbar-brand" href="#" style="color:white;">
            Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>