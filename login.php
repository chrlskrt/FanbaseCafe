<?php
    include("connect.php");
    include_once("includes/header.php");
?>
<!-- MODALS -->
<div class="modal fade" tabindex="-1" role="dialog" id="errorModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Whoops</h5>
      </div>
      <div class="modal-body">
        <p>Username and password does not match anything in our records. Try again or sign up.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="register.php" class="btn btn-outline-success">Sign Up</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="unameErrorModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Whoops</h5>
      </div>
      <div class="modal-body">
        <p> Username does not exists in our records. Try again or sign up.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="register.php" class="btn btn-outline-success">Sign Up</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="passErrorModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Whoops</h5>
      </div>
      <div class="modal-body">
        <p>Incorrect password.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <a href="register.php" class="btn btn-outline-success">SIGN UP</a> -->
      </div>
    </div>
  </div>
</div>

<section class="CreateNLog">
    <div>
        <p class="label">Log In</p>
        <form action="login.php" method="post">
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
        <p>Don't have an account? <a href="register.php" style="color:blue">Sign Up</a></p>
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
    if($_SERVER['REQUEST_METHOD']==='POST'){
		$uname = $_POST['username'];
		$pass = $_POST['password'];
		//check tbluseraccount if username is existing
		$sql ="SELECT * from tbluseraccount where username='".$uname."'";
		
		$result = mysqli_query($connection,$sql);	
		
		$count = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		

        if ($count != 0 && password_verify($pass, $row[4])){
            // if naa nay concept na log-out log-out or mag add ta
            // $logInCookie = urlencode(base64_encode(serialize($row)));
            // setcookie('user', $logInCookie, time() + (86400 * 30), "/");
			echo "<script language='javascript'>
                        window.location.replace('index.php');
                </script>";
        } else if($count == 0) {
			echo "<script language = 'javascript'>
						$(function(){
                            $('#unameErrorModal').modal('show');
                        })
				  </script>";
		 } else {
            echo "<script language = 'javascript'>
						$(function(){
                            $('#username').val('".$uname."');
                            $('#passErrorModal').modal('show');
                        })
				  </script>";
		}
	}
?>