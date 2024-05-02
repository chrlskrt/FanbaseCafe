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
        <div class="btn label" id="appReportDiv" style="font-size: 4vw; text-align:left">+ App Report</div>
        
        <div style="display: flex; flex-wrap:wrap;justify-content: space-around" id="appReportDiv2">
            <?php
                echo getAppReports();
            ?>
        </div>
    </div>

    <div class="manageAppDiv" style="border-top: 2px black solid;">
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
                echo getFanbasesTable();
            ?>
        </div>
    </div>

    <div class="manageAppDiv">
        <div class="btn label" id="manageUsersDiv" style="font-size: 4vw; text-align:left">+ Manage Users</div>
        
        <div style="display: flex; justify-content: center;" id="manageUsersTable">
            <?php
                echo getUsersTable();
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
  /* MODAL HANDLERS */
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
?>