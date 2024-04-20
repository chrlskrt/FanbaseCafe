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

<div class="main-container" style="padding-top:100px; flex-direction:row;">

    <div class="white-container" id="displayProfile" style="flex-direction: column; justify-content: space-evenly;">
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
            </div>
            
        </div>
    </div>

    <img src="images/profileBG.png" style="margin:auto;overflow:hidden;box-shadow: 8px 10px 5px #9fc0c1;">

</div>

<div class="main-container" style="padding-top:100px; flex-direction:row;">

<div class="white-container" id="displayProfile" style="flex-direction: column; justify-content: space-evenly;">
    
    <div id="editProfile">
        <img src="images/account.png" class="card2-logo" style="height:120px; width: 120px;">
        <div class="manageFanbaseDiv" >
            <form action="updateFanbaseDetails.php" method="post">
                <div class="formsch">
                    <div class="form-group" > 
                        <div class="label" style="font-weight:unset; font-size: 3vw;"> First Name:</div>
                        <textarea class="form-control" id="date_created" name="date_created" value="<?php echo ($fanbase['date_created']) ?>" required> </textarea>
                    </div>
                    <div class="form-group" style="margin-top:2vw;">
                        <div class="label" style="font-weight:unset; font-size: 3vw;">Last Name: </div>
                        <textarea class="form-control" name="fanbase_description" id="fanbase_description" required><?php echo ($fanbase['fanbase_description']) ?></textarea>
                    </div>
                    <div style="display:flex; justify-content:space-between">
                        <button id="cancelEditProf" type="button" class="btn btn-outline-danger" >Cancel Edit</button>
                        <button id="btnUpdateProf" value="1" type="submit" role="button" class="btn btn-success">Update Profile </button>
                    </div>
                </div>
            </form>
        </div>
<!-- <img src="images/profileBG.png" style="margin:auto;overflow:hidden;box-shadow: 8px 10px 5px #9fc0c1;"> -->
    </div>


</div>

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>