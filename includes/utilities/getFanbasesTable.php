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

function getAppReports(){
    global $connection;

    // get top 3 fanbases with most members
    $sqlFanbase = "SELECT fanbase_name, count(acc_fanbase_id) as MemberCount 
                   FROM tblfanbase, tbluseraccount_fanbase 
                   WHERE tblfanbase.fanbase_id = tbluseraccount_fanbase.fanbase_id 
                   GROUP BY tblfanbase.fanbase_id 
                   ORDER BY MemberCount DESC";

    $result = mysqli_query($connection, $sqlFanbase);

    $topFanbasesArr = array();

    $fanbaseTopStr = "<div style='display: flex; flex-direction: column; justify-content: center; border: none; font-size:2vw'>
                        TOP 3 FANBASE w MOST MEMBERS
                        <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                            <thead>
                                <tr>
                                    <th scope='col'>Top</th>
                                    <th scope='col'>Fanbase</th>
                                    <th scope='col'>Fans</th>
                            </thead>
                            <tbody>";

    if ($result){
        while($row = $result->fetch_assoc()){
            $topFanbasesArr[] = $row;
        }

        $result->free();

        $topFanbasesArr = array_splice($topFanbasesArr, 0, 3);

        $count = 1;
        foreach($topFanbasesArr as $fanbase){
            $fanbaseTopStr .= '
                <tr>
                    <th scope="row">'.$count.'</td>
                    <td>'.$fanbase['fanbase_name'].'</td>
                    <td>'.$fanbase['MemberCount'].'</td>
                </tr>
            ';

            $count++;
        }
    }

    $fanbaseTopStr .= '</tbody></table></div></div>';

    // // get top 3 fanbases with most posts 
    // $sqlMostPost = "SELECT fanbase_name, count(tblpost.fanbase_id) as PostCount 
    //                 FROM tblfanbase, tblpost 
    //                 WHERE tblfanbase.fanbase_id = tblpost.fanbase_id 
    //                 GROUP BY tblfanbase.fanbase_id";
    // $result = mysqli_query($connection, $sqlMostPost);

    // $topPostArr = array();

    // $postTopStr = "<div style='display: flex; flex-direction: column; justify-content: center; border: none; font-size:2vw'>
    //                 TOP 3 FANBASE w MOST POSTS
    //                 <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
    //                     <thead>
    //                         <tr>
    //                             <th scope='col'>Top</th>
    //                             <th scope='col'>Fanbase</th>
    //                             <th scope='col'>Number of Posts</th>
    //                     </thead>
    //                     <tbody>";

    // if ($result){
    //     while ($row = $result->fetch_assoc()){
    //         $topPostArr[] = $row;
    //     }

    //     $result->free();

    //     $topPostArr = array_splice($topPostArr, 0, 3);

    //     $count = 1;
    //     foreach($topPostArr as $fanbase){
    //         $postTopStr .= '
    //             <tr>
    //                 <th scope="row">'.$count.'</td>
    //                 <td>'.$fanbase['fanbase_name'].'</td>
    //                 <td>'.$fanbase['PostCount'].'</td>
    //             </tr>
    //         ';

    //         $count++;
    //     }
    // }

    // $postTopStr .= '</tbody></table></div></div>';
    // get events with type ""
    $sqlEvent = "SELECT event_id, fanbase_name, event_name, event_description 
                 FROM tblevent, tblfanbase 
                 WHERE tblevent.fanbase_id = tblfanbase.fanbase_id AND event_type = 'MEET & GREET'";
                 
    $result = mysqli_query($connection, $sqlEvent);

    $eventArr = array();

    $eventStr = "<div style='display: flex; flex-direction: column; justify-content: center; border: none; font-size:2vw'>
                    EVENTS with type: meet & greet
                    <div class='table-responsive-lg'><table class='table table-bordered table-hover manageAppTable'>
                        <thead>
                            <tr>
                                <th scope='col'>Event ID</th>
                                <th scope='col'>Fanbase</th>
                                <th scope='col'>Event</th>
                                <th scope='col'>Event Description</th>
                        </thead>
                        <tbody>";

    if ($result){
        while ($row = $result->fetch_assoc()){
            $eventArr[] = $row;
        }

        $result->free();

        foreach($eventArr as $event){
            $eventStr .= '
                <tr>
                    <th scope="row">'.$event['event_id'].'</td>
                    <td>'.$event['fanbase_name'].'</td>
                    <td>'.$event['event_name'].'</td>
                    <td>'.$event['event_description'].'</td>
                </tr>
            ';
        }
    }

    $eventStr .= '</tbody></table></div></div>';

    // return $fanbaseTopStr.$postTopStr.$eventStr;
    return $fanbaseTopStr.$eventStr;
}