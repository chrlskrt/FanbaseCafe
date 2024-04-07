<?php
    if (isset($_POST['promoteUser'])){
        echo ("PROMOTING USER ID: " . $_POST['promoteUser']);
    }

    if (isset($_POST['demoteUser'])){
        echo ("DEMOTING USER ID: " . $_POST['demoteUser']);
    }

    if (isset($_POST['deleteUserAcc'])){
        echo ("DELETING USER ID: " . $_POST['deleteUserAcc']);
    }
?>