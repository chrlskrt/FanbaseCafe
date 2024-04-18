<?php

/* manageApp.php */
function getFanbasesTable(){
    global $connection;

    // getting ALL data from tblfanbase
    $sqlfanbase = "SELECT * FROM tblfanbase";
    $resultfanbase = mysqli_query($connection, $sqlfanbase);
    
    // creating an empty array
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

    // creating the html table, gistore ra siya as string na iprint later on
    $tableStr = "<div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Artist</th>
                            <th scope='col'>Fanbase Name</th>
                            <th scope='col'>Date Created</th>
                            <th scope='col'>Fanbase Description</th>
                            <th scope='col'>        </th>
                        </tr>
                    </thead>
                    <tbody>";

    // looping thru every fanbase entry
    foreach($fanbaseArray as $fanbase){
        $tableStr .= '
            <tr>
                <th scope="row">'.$fanbase['fanbase_id'].'</td>
                <td>'.$fanbase['fanbase_artist'].'</td>
                <td>'.$fanbase['fanbase_name'].'</td>
                <td>'.$fanbase['date_created'].'</td>
                <td>'.$fanbase['fanbase_description'].'</td>
                <td><a href="manageFanbase.php?fanbase='.$fanbase['fanbase_name'].'" class="btn btn-outline-success">Edit</a></td>
            </tr>
        ';
    }

    $tableStr .= '</tbody></table></div>';

    return $tableStr;
}