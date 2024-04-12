<?php
    $accID = $_POST["fanbaseMember"];
    $fanbaseID = $_POST["fanbaseName"];

    echo "$accID <br>";
    echo "$fanbaseID";

    $query = INSERT INTO tbluseraccount_fanbase (account_id, fanbase_id, date_joined,)
?>