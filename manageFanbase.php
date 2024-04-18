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
            echo getMembersTable($fanbaseName);
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