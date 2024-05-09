<?php

/* index.php */
function getFanbases() {
    global $connection;

    $sqlfanbase = "SELECT * FROM tblfanbase WHERE isDeleted = 0";
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
        <img src="images/grpPhoto/'.$fanbase['fanbase_photo'].'" class="card2-img">
        <div class="cardContent">
            <img src="images/grpLogo/'.$fanbase['fanbase_logo'].'" class="card2-logo"> 
            <p class="card2-name">'.$fanbase['fanbase_artist'].' </p>
        </div>
        </a>

    ';
    }

    return $fanbaseCard;
}