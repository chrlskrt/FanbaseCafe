<?php

/* index.php */
function getFanbases() {
    global $connection;

    $sqlfanbase = "SELECT * FROM tblfanbase";
    $resultfanbase = mysqli_query($connection, $sqlfanbase);
    
    $fanbaseArray = array();

    if ($resultfanbase){
        /* query is a success
        /* looping thru every row of record sa tblfanbase */
        while ($row = $resultfanbase->fetch_assoc()) {
            /* $row = 1 fanbase entry
            /* iadd siya sa fanbase array */
            $fanbaseArray[] = $row;
        } 

        $resultfanbase->free(); // freeing result set
    }

    $fanbaseCard = NULL;

    foreach($fanbaseArray as $fanbase) {
    $fanbaseCard .= '
    
        <a href="fanbase.php?fanbase_ID='.$fanbase['fanbase_id'].'" class="card2">
        <img src="images/grp'.$fanbase['fanbase_name'].'.jpg" class="card2-img">
        <div class="cardContent">
            <img src="images/grp'.$fanbase['fanbase_name'].'Logo.jpg" class="card2-logo"> 
            <p class="card2-name">'.$fanbase['fanbase_artist'].' </p>
        </div>
        </a>

    ';
    }

    return $fanbaseCard;
}