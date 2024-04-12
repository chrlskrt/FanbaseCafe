<?php
    include ("includes/api.php");
    $fanbaseID = $_POST['fanbase_id'];

    if (isset($_POST['promoteUser'])){
        echo ("PROMOTING USER ID: " . $_POST['promoteUser'] . '<br> in FANBASE: '. $fanbaseID);
        $account_id = $_POST['promoteUser'];
    }

    if (isset($_POST['demoteUser'])){
        echo ("DEMOTING USER ID: " . $_POST['demoteUser'] . '<br> in FANBASE: '. $fanbaseID);
        $account_id = $_POST['demoteUser'];
    }

    if (isset($_POST['removeUser'])){
        echo ("REMOVING USER ID: " . $_POST['removeUser'] . '<br> in FANBASE: '. $fanbaseID);
        $account_id = $_POST['removeUser'];
    }
?>