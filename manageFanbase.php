<?php
    include("includes/header.php");

    $fanbase_id = $_GET['fanbase'];

    $sqlFanbase = "SELECT * FROM tblFanbase WHERE fanbase_id='".$fanbase_id."'";
    $resultFanbase = $connection->query($sqlFanbase);
    $fanbase = mysqli_fetch_array($resultFanbase);
?>

<script src="js/manageFanbase.js"></script>

<div class="manageFanbaseDiv justify-content-center" style="gap:50px; height: 78vh">
    <div class="d-flex" style="flex-direction:row; justify-content:space-around; border:none">
        <div style="width: 300px; box-shadow:none">
            <img src="images/grpPhoto/<?php echo $fanbase['fanbase_photo'] ?>" class="card2-img" style="height: 300px; width:300px">
            <div class="cardContent" style="flex-direction:row;box-shadow:none">
                <img src="images/grpLogo/<?php echo $fanbase['fanbase_logo'] ?>" class="card2-logo" style="align-self:flex-start; margin-top: 10px; margin-left:5px"> 
                <div class="d-flex" style="flex-direction:column; flex:1; padding:10px">
                    <div class="label" style="font-size:30px"><?php echo ($fanbase['fanbase_artist']) ?></div>
                    <div class="label" style="font-weight:normal; font-size:25px"><?php echo ($fanbase['fanbase_name']) ?></div>
                </div>
            </div>
        </div>
       
        <div class="manageFanbaseDiv" id="displayFanbaseDetailsDiv">
            <div class="label" style="font-weight: unset">Date founded: <br><b><?php echo ($fanbase['date_created']) ?></b></div>
            <div class="label" style="font-weight: unset">Description: <br><b><i>"<?php echo ($fanbase['fanbase_description']) ?>"</i></b></div>
            
            <div style="flex-direction: row; border: none">
                <button  id="btnDeleteFanbase" class="btn btn-outline-danger">Delete Fanbase</button>
                <button  type="button" class="btn btn-light" id="edit">Edit Fanbase Details</button>
                <br>
                <button class="btn btn-outline-dark" id="btnManageMembers">Manage Fanbase MEMBERS</button>
            </div>
        </div>
    </div>
</div>

<div class="manageFanbaseDiv" id="manageMembers" style="padding:0">
    <hr>
    <div class="label" style="font-size: 35px">Manage Fanbase Members</div>
    <div class="manageFanbaseDiv" style="border:none">
        <?php
            echo getMembersTable();
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

<!-- MODAL DELETE FANBASE -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteFanbaseModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete Fanbase</h5>
        </div>
        <div class="modal-body">
            <p> Are you sure? This action cannot be undone! </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
            <form action="php/deleteFanbase.php" method="POST">
                <button value="<?php echo $fanbase_id ?>" name="fanbase_id" type="submit" role="button" class="btn btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- edit fanbase modal -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" role="dialog" id="editFanbaseModal">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="gap:10px;" role="document">
    <div class="modal-content">
        <div class="modal-header justify-content-center">
            <h5 class="modal-title"> Edit Fanbase Details </h5>
        </div>
        <form action="php/updateFanbaseDetails.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="flex-container" style="flex-direction:column; align-items: center; ">
                    <div class="formsch">
                        <div class="form-group" > 
                            <label for="date_created">Date created: </label>
                            <input type="date" class="form-control" id="date_created" name="date_created" value="<?php echo ($fanbase['date_created']) ?>" required>
                        </div>
                        <div class="form-group" style="margin-top:2vw;">
                            <label for="fanbase_description">Description: </label>
                            <textarea rows="6" class="form-control" name="fanbase_description" id="fanbase_description" style="height:max-content" required><?php echo ($fanbase['fanbase_description']) ?></textarea>
                        </div>
                        <div>
                            <label for="fanbase_photo" class="form-label">Fanbase Photo</label>
                            <input type="hidden" name="old_photo" value="<?php echo ($fanbase['fanbase_photo']) ?>">
                            <input class="form-control" type="file" name="fanbase_photo" id="fanbase_photo" accept="image/jpg, image/jpeg, image/png">
                        </div>
                        <div >
                            <label for="fanbase_logo" class="form-label">Fanbase Logo</label>
                            <input type="hidden" name="old_logo" value="<?php echo ($fanbase['fanbase_logo']) ?>">
                            <input class="form-control" type="file" name="fanbase_logo" id="fanbase_logo" accept="image/jpg, image/jpeg, image/png">
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel Edit</button>
                <button id="btnUpdateFanbaseDetails" value="<?php echo $fanbase_id ?>" name="fanbase_id" type="submit" role="button" class="btn btn-success">Update Details</button>
            </div>
        </form>
    </div>

    <div style="display:flex; align-self:flex-start">
        <button type="button" class="modal-content modal-exit-btn" data-bs-dismiss="modal">X</button>
    </div>
  </div>
</div>