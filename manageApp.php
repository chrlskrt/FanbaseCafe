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

<div class="manageAppDiv" id="createFanbaseDiv">
    <a class="btn label" style="font-size: 5w; text-align:left">+ Create Fanbase</a>
    
    <div style="display: flex; justify-content: center;" id="createFanbaseForm">
        <form action="createFanbase.php" method="post">
            <div class="formsch">
                <div class="form-floating mb-3">
                    
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username..." required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password..." required>
                    <label for="password">Password</label>
                </div>
                <button id="btnLogIn" value="1" type="submit" role="button" class="btn btn-outline-dark btn-lg btn-block">Log In</button>

            </div>
        </form>
    </div>
</div>

<div class="manageAppDiv" id="manageFanbasesDiv">
    <div class="btn label" style="font-size: 5w; text-align:left">+ Manage Fanbases</div>
    
    <div style="display: flex; justify-content: center;" id="manageFanbasesTable">
        <?php
            echo displayFanbasesTable();
        ?>
    </div>
</div>

<div class="manageAppDiv" id="manageUsersDiv">
    <a class="btn label" style="font-size: 5w; text-align:left">+ Manage Users</a>
    
    <div style="display: flex; justify-content: center;" id="manageUsersTable">
        <?php
            echo displayUsersTable();
        ?>
    </div>
</div>


<?php
    function displayFanbasesTable(){

    }

    function displayUsersTable(){

    }
?>