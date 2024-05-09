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

<!-- main1 -->
<div class="main-container" id="displayProfile" style="padding-top:100px; flex-direction:row;">

    <div class="white-container" style="flex-direction: column; justify-content: space-around;">
        <img src="images/account.png" class="card2-logo" style="height:120px; width: 120px;">
        
        <div class="flex-container">
            
            <div class="label" style="text-align:center"> <?php echo $current_user['username'] ?>
                <div class="text"> 
                    <div class="text" style="color:gray">
                        <?php echo $current_user['account_id'] ?> 
                    </div>
                    <?php echo "Name: " .$userProf['firstname'] ?> 
                    <?php echo $userProf['lastname'] ?> 
                </div>

                <div class="text">
                    <?php echo "Birthday: " .$userProf['birthdate'] ?> 
                </div>

                <div class="text">
                    <?php //echo "Joined Fanbases: " .$userProf['birthdate'] ?>  
                    Joined Fanbases: BlackPink, TXT, Seventeen
                </div>
                <button type="button" class="btn btn-outline-dark" id="btnUpdateProf">Update Profile</button>
                <a role="button" href="deleteaccount.php" class="btn btn-danger" id="btnDelete"> Delete Account </a>
            </div>
            
        </div>
    </div>

    <img src="images/profileBG.png" style="overflow:hidden;box-shadow: 8px 10px 5px #9fc0c1;">

<!-- main1 -->
</div>

<div class="main-container"  id="editProfile" style="padding-top:100px; flex-direction:row;">

    <div class="white-container" style="flex-direction: column; justify-content: space-evenly;">
        <img src="images/account.png" class="card2-logo" style="height:120px; width: 120px;">
            <div class="text" style="color:gray">
                <?php echo $current_user['account_id'] ?> 
            </div>
    
    <div> 
        <?php
            $stmtUpdateFanbase = "SELECT firstname, lastname, birthdate FROM tbluserprofile WHERE user_id = {$current_user['user_id']}";
            
            $result = mysqli_query($connection,$stmtUpdateFanbase);
            $profileArray = mysqli_fetch_array($result);

            $old_firstname = $profileArray['firstname'];
            $old_lastname = $profileArray['lastname'];
            $old_birthdate = $profileArray['birthdate'];
        ?>

        <div class="manageFanbaseDiv" >
            <form action="php/updateProfileDetails.php" method="post">
                <div class="formsch">
                    <div class="form-group" > 
                        <div class="label" style="text-align:center"> <?php echo $current_user['username'] ?> </div>
                        <div class="text"> First Name:</div>
                        <input class="form-control" style="height:50px;" id="new_fname" name="new_fname" value="<?php echo $old_firstname?>"> </input>
                        <div class="text">Last Name: </div>
                        <input class="form-control" name="new_lname" id="new_lname" value="<?php echo $old_lastname?>"> </input>
                        <div class="text"> Birthday: </div>
                        <input type="date" class="form-control" name="new_bday" id="new_bday" value="<?php echo $old_birthdate?>"> </input>
                    </div>
                    
                    <br>

                    <div style="display:flex; justify-content:space-between">
                        <button id="cancelEditProf" role="button" class="btn btn-outline-danger" >Cancel Edit</button>
                        <button id="btnUpdateProf" value="1" type="submit" role="button" class="btn btn-success">Update Profile </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    </div>
    
    <img src="images/profileBG.png" style="overflow:hidden;box-shadow: 8px 10px 5px #9fc0c1;">
<!-- main -->
</div>

<!-- MODAL DELETE ACCOUNT -->
<!-- <div class="modal fade" tabindex="-1" role="dialog" id="regSuccessModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Success!</h5>
      </div>
      <div class="modal-body">
        <p>Resgistration is a success, try logging in </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="login.php" class="btn btn-outline-success">Log In </a>
      </div>
    </div>
  </div>
</div> -->

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>