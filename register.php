<?php 
    include("connect.php");
    require_once("includes/header.php");
?>

<script src="js/register.js"></script>


<section class="CreateNLog">
    <div>
        <div class="label">Register</div>
        <form action="register.php" method="post">
            <div class="formsch">

                <div class="flex-container" style="justify-content:space-between;">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required>
                        <label for="firstname">First Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required>
                        <label for="lastname">Last Name</label>
                    </div>
                </div>    

                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                    <label for="birthdate">Birthday:</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    <label for="email">Email</label>
                </div>
                    
                <div class="form-floating mb-3"> 
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>

                <div class="form-floating mb-3"> 
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
            
                <div class="form-floating mb-3"> 
                    <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirm Password" required>
                    <label for="cpassword">Confirm Password</label>
                </div>
            
                <button id="btnRegister" type="submit" role="button" class="btn btn-outline-warning btn-lg btn-block" 
                value="1">Sign Up</button>
            </div>
        </form>

        <p>Already have an account? <a href="login.php" style="color:blue">Log In</a></p>
    </div>
</section>


<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Charlene Repuesto
            <br>
            BSCS 2
        </a>
    </nav>
</footer>

<?php	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){		
		//retrieve data from form and save the value to a variable
		//for tbluserprofile
		$fname=$_POST['firstname'];		
		$lname=$_POST['lastname'];
		$bdate=$_POST['birthdate'];
		
		//for tbluseraccount
		$email=$_POST['email'];		
		$uname=$_POST['username'];
		$pword=password_hash($_POST['password'], PASSWORD_BCRYPT);

        // validating unique value for firstname, lastname and birthdate fields
        $sqlTblUserProfileValidation = "SELECT * FROM tbluserprofile WHERE firstname = '$fname' AND lastname = '$lname' AND birthdate = '$bdate'";
        $user_result = mysqli_query($connection, $sqlTblUserProfileValidation);
        $tbluserprofile_row = mysqli_num_rows($user_result);
        
        if ($tbluserprofile_row == 0){ // user does not exist
            //save data to tbluserprofile			
            $sql1 ="INSERT into tbluserprofile(firstname,lastname,birthdate) values('".$fname."','".$lname."', '".$bdate."')";
            mysqli_query($connection,$sql1);
        } else {
            $user = mysqli_fetch_array($user_result);
            // getting id from tbluserprofile
            $user_id = $user[0];

            // validate if user already has an account
            $sqlTblUserAccountValidation = "SELECT * FROM tbluseraccount WHERE user_id = '$user_id'";
            $acc_result = mysqli_query($connection, $sqlTblUserAccountValidation);
            $tbluseraccount_row = mysqli_num_rows($acc_result);

            if ($tbluseraccount_row != 0){
                // if user already has an account, pop modal

                echo "<script language='javascript>
                    $('userExistsModal').modal('show');
                </script>";

                return;
            }
        }

        // validate email in tbluseraccount
		$sqlUserEmailValidation = "SELECT email_add FROM tbluseraccount WHERE email_add = '$email'";
        $email_result = mysqli_query($connection, $sqlUserEmailValidation);
        $email_row = mysqli_num_rows($email_result);

        if ($email_row != 0){
            // email already taken
            echo "<script language='javascript'>
                $('emailExistsModal').modal('show');
            </script>";
        }

        // validate username in tbluseraccount
        $sqlUsernameValidation = "SELECT username FROM tbluseraccount WHERE username = '$uname'";
        $username_result = mysqli_query($connection, $sqlUsernameValidation);
        $username_row = mysqli_num_rows($username_result);

        if ($username_row!= 0){
            // username already taken
            echo "<script language='javascript'>
                $('usernameExistsModal').modal('show');
            </script>";
        }

        if ($tbluserprofile_row == 0){
            $sqlUser_ID = $connection -> insert_id;
        } else {
            $sqlUser_ID = $user_id;
        }

        $sql ="Insert into tbluseraccount(user_id, email_add,username,password) values('.$sqlUser_ID.', '".$email."','".$uname."','".$pword."')";
        mysqli_query($connection,$sql);
        echo "<script language='javascript'>
                    $('regSuccessModal').modal('show');
                    window.location.replace('login.php');
                </script>";
        exit();
	}
		
?>

<!-- MODALS -->
<div class="modal fade" tabindex="-1" role="dialog" id="userExistsModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OMO!!</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>We've noticed that you already have an account. Kindly try logging in.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="login.php" class="btn btn-outline-success">LOG IN</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="emailExistsModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OMO!!</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This email is already taken, try another one.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="usernameExistsModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OMO!!</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This username is already taken, try another one.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="reSuccessModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">YEYY!!</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>REGISTRATION is a SUCCESS. LOG IN now!!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="login.php" class="btn btn-outline-success">LOG IN</a>
      </div>
    </div>
  </div>
</div>