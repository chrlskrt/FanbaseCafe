<?php
    include("includes/api.php");
    date_default_timezone_set('Asia/Manila');

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $fname = $_POST['fanbase_name'];
        $artist = $_POST['fanbase_artist'];
        $desc = $_POST['fanbase_description'];
		$date = date('Y-m-d');
        // var_dump($_FILES['fanbase_photo']['UPLOAD_ERR_INI_SIZE']);
        $photo = $_FILES['fanbase_photo']['name'];
        $photo_tmp = $_FILES['fanbase_photo']['tmp_name'];
        $photo_folder = "./images/grpPhoto/".$photo;
        $logo = $_FILES['fanbase_logo']['name'];
        $logo_tmp = $_FILES['fanbase_logo']['tmp_name'];
        $logo_folder = "./images/grpLogo/".$logo;

        // storing current form submission into session for later use
        $_SESSION['createFanbase_data'] = $_POST;
       
        // check if the artist has a fanbase already
        $sqlF = 'SELECT fanbase_id FROM tblfanbase WHERE fanbase_artist = "'.$artist.'"';
        $sqlFRes = mysqli_query($connection, $sqlF);
        $sqlFCount = mysqli_num_rows($sqlFRes);

        if ($sqlFCount != 0){
            header('Location: manageApp.php?artistFanbase_exists');
            exit();
        } 
        
        // checking if the fanbase name is already taken
        $sqlFName = 'SELECT fanbase_id FROM tblfanbase WHERE fanbase_name = "'.$fname.'"';
        $sqlFNRes = mysqli_query($connection, $sqlFName);
        $sqlFNCount = mysqli_num_rows($sqlFNRes);

        if ($sqlFNCount != 0){
            header('Location: manageApp.php?fanbaseName_exists');
            exit();
        }

        // creating the fanbase | inserting new fanbase record into tblFanbase
        $sqlCreate ="INSERT into tblfanbase(fanbase_name,fanbase_artist, date_created, fanbase_description, fanbase_photo, fanbase_logo) values ('$fname', '$artist','$date','$desc', '$photo','$logo')";
        mysqli_query($connection,$sqlCreate);

        // moving the photo and logo to the server
        move_uploaded_file($photo_tmp, $photo_folder);
        move_uploaded_file($logo_tmp, $logo_folder);
        
		header('Location: manageApp.php?fanbaseCreate_success');
        exit();
	}
?>