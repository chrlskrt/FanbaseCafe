<?php

/* fanbase.php */
function getEvents($fanbaseID){
    global $connection, $current_user;

    // getting the member info of the current_user from tbluseraccount_fanbase 
    $sqlCurrFanbaseMember = "SELECT * FROM tbluseraccount_fanbase WHERE fanbase_id = {$fanbaseID} AND account_id = {$current_user['account_id']}";
    $resMem = mysqli_fetch_array(mysqli_query($connection, $sqlCurrFanbaseMember));
    $isFanbaseAdmin = $resMem['isAdmin'];
    
    // getting ALL events for this fanbase from tblevent
    $sqlevents = "SELECT * FROM tblevent WHERE fanbase_id = {$fanbaseID}";
    $resultevents = mysqli_query($connection, $sqlevents);
    
    // var_dump(mysqli_fetch_array($resultevents));
    // creating an empty array
    $fanbaseEventsArr = array();

    if ($resultevents){
        /* query is a success
        /* looping thru every row of record sa tblfanbase */
        while ($row = $resultevents->fetch_assoc()) {
            /* $row = 1 fanbase entry — iadd siya sa fanbase array */

            /* setting date format for easy read */
            $row['event_date'] = date_format(date_create($row['event_date']), "F d, Y");
            $row['event_time'] = date_format(date_create($row['event_time']), "g:i A");

            /* getting organizer info using account_id */
            $mysqlUser = "SELECT * from tbluseraccount WHERE account_id = {$row['account_id']}";
            $res = mysqli_query($connection, $mysqlUser);

            /* storing organizer into account_id */
            $row['account_id'] = mysqli_fetch_array($res);

            /* adding the record into the array */
            $fanbaseEventsArr[] = $row;
        } 

        $resultevents->free(); // freeing result set
    }

    $eventsStr = '';
    foreach ($fanbaseEventsArr as $fanbaseEvent) {
        $eventsStr .= '
            <div class="flex-container dd" style="margin-bottom:5px;">
                <div class="white-container">
                    <div class="main-container-nopaddings">
                        <div class="flex-container" style="justify-content: space-between">
                            <b>'.$fanbaseEvent['event_name'].'</b>'.
                            /* if the current_user is an admin of the fanbase
                            /* or the ORGANIZER of the event, they can delete event */
                            (($isFanbaseAdmin == 1 || $current_user['account_id'] == $fanbaseEvent['account_id']['account_id']) ? 
                                '<form action="deleteEvent.php" method="POST">
                                    <input type="hidden" name="fanbase_id" value="'.$fanbaseEvent['fanbase_id'].'">
                                    <button class="btn btn-outline-dark" name="deleteEvent" value="'.$fanbaseEvent['event_id'].'" role="button" type="submit">Delete Event</button> 
                                </form>'
                            : '')
                        .'</div>
                        <hr>
                        <div class="text"> A '.$fanbaseEvent['event_type'].' Event 
                            <div class="text" style="color:#808080; padding: 0px"> Organizer: '.$fanbaseEvent['account_id']['username'].' </div>
                            <div class="text" style="color:#808080; padding-top: 0px"> Date: '.$fanbaseEvent['event_date'].' Time: '.$fanbaseEvent['event_time'].' Location: '.$fanbaseEvent['event_location'].' </div>
                            '.$fanbaseEvent['event_description'].'
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    return $eventsStr;
}