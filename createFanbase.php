<?php
    include("includes/api.php");
    date_default_timezone_set('Asia/Manila');

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $fname = $_POST['fanbase_name'];
        $artist = $_POST['fanbase_artist'];
        $desc = $_POST['fanbase_description'];
		$date = date('Y-m-d');

        $_SESSION['createFanbase_data'] = $_POST;
        // var_dump($date);
        
        // check if the artist has a fanbase already
        $sqlF = 'SELECT fanbase_id FROM tblfanbase WHERE fanbase_artist = "'.$artist.'"';
        $sqlFRes = mysqli_query($connection, $sqlF);
        $sqlFCount = mysqli_num_rows($sqlFRes);

        if ($sqlFCount != 0){
            header('Location: manageApp.php?artistFanbase_exists');
            exit();
        } 
        
        $sqlFName = 'SELECT fanbase_id FROM tblfanbase WHERE fanbase_name = "'.$fname.'"';
        $sqlFNRes = mysqli_query($connection, $sqlFName);
        $sqlFNCount = mysqli_num_rows($sqlFNRes);

        if ($sqlFNCount != 0){
            header('Location: manageApp.php?fanbaseName_exists');
            exit();
        }

        // unset($_SESSION['createFanbase_data']);

        $sqlCreate ="INSERT into tblfanbase(fanbase_name,fanbase_artist, date_created, fanbase_description) values ('".$fname."', '".$artist."','".$date."','".$desc."')";
        mysqli_query($connection,$sqlCreate);

		header('Location: manageApp.php?fanbaseCreate_success');
        exit();
	}
?>