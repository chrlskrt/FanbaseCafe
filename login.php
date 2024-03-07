<?php
    include("connect.php");
    include_once("includes/header.php");
?>

<section class="CreateNLog">
    <div>
        <p class="headingForm">Log In</p>
        <form action="" method="post">
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
        <p>Don't have an account? <a href="register.html" style="color:blue">Register</a></p>
    </div>
</section>

<footer>
    <nav class="navbar navbar-success bg-success">
        <a class="navbar-brand" href="#">
            Charlene Repuesto
            <br>
            BSCS 2
        </a>
    </nav>
</footer>

<?php	
	if(isset($_POST['btnLogin'])){
		$uname=$_POST['username'];
		$pwd=$_POST['password'];
		//check tbluseraccount if username is existing
		$sql ="Select * from tbluseraccount where username='".$uname."'";
		
		$result = mysqli_query($connection,$sql);	
		
		$count = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		
		if($count== 0){
			echo "<script language='javascript'>
						alert('username not existing.');
				  </script>";
		}else if($row[3] != $pwd) {
			echo "<script language='javascript'>
						alert('Incorrect password');
				  </script>";
		}else{
			$_SESSION['username']=$row[0];
			header("location: index.php");
		}
	}
?>