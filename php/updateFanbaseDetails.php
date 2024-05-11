<?php
    include ("../connect.php");
    include ("../includes/api.php");

    var_dump($_POST);
    var_dump($_FILES);

    $fanbase_id = $_POST['fanbase_id'];
    $new_desc = $_POST['fanbase_description'];
    $new_date = $_POST['date_created'];
    // var_dump($_FILES['fanbase_photo']['UPLOAD_ERR_INI_SIZE']);
    if ($_FILES['fanbase_photo']['name'] != ''){
        $new_photo = $_FILES['fanbase_photo']['name'];
        $photo_tmp = $_FILES['fanbase_photo']['tmp_name'];
        $photo_folder = "../images/grpPhoto/".$new_photo;
        move_uploaded_file($photo_tmp, $photo_folder);
    } else {
        $new_photo = $_POST['old_photo'];
    }

    if ($_FILES['fanbase_logo']['name'] != ''){
        $new_logo = $_FILES['fanbase_logo']['name'];
        $logo_tmp = $_FILES['fanbase_logo']['tmp_name'];
        $logo_folder = "../images/grpLogo/".$new_logo;
        move_uploaded_file($logo_tmp, $logo_folder);
    } else {
        $new_logo = $_POST['old_logo'];
    }


    echo "<br>";
    echo "<br> Fanbase_photo: ".$new_photo;
    echo "<br> Fanbase_logo: ".$new_logo;
    $stmtUpdateFanbase = $connection->prepare("UPDATE tblFanbase 
                                                SET fanbase_description = ? , date_created = ? , fanbase_photo = ? , fanbase_logo = ?
                                                WHERE fanbase_id = ?");
    $stmtUpdateFanbase->bind_param("ssssi", $new_desc, $new_date, $new_photo, $new_logo, $fanbase_id);
    $stmtUpdateFanbase->execute();
    $stmtUpdateFanbase->close();

    
    header("Location: ../manageFanbase.php?fanbase={$fanbase_id}");
    exit();
?>