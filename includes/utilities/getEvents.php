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

            /* storing number of event participants */
            $sqlNumParticipants = "SELECT count(*) FROM tblevent_participant WHERE event_id = {$row['event_id']}";
            $res = mysqli_query($connection, $sqlNumParticipants);
            $row['numberOfParticipants'] = mysqli_fetch_array($res)[0];

            /* storing if the current user has joined the event as participant */
            $sqlParticipant = "SELECT account_id FROM tblevent_participant WHERE event_id = {$row['event_id']} AND account_id={$current_user['account_id']}";
            $res = mysqli_query($connection, $sqlParticipant);
            $row['hasJoined'] = mysqli_num_rows($res);

            /* adding the record into the array */
            $fanbaseEventsArr[] = $row;
        } 

        $resultevents->free(); // freeing result set
    }

    $eventsStr = '';
    foreach ($fanbaseEventsArr as $fanbaseEvent) {
        $eventsStr .= '
            <div class="flex-container" id="event'.$fanbaseEvent['event_id'].'" style="margin-bottom:5px;">
                <div class="white-container">
                    <div class="main-container-nopaddings">
                        <div class="flex-container" style="justify-content: space-between">
                            <b>'.$fanbaseEvent['event_name'].'</b>
                            <div style="display:flex; gap:10px">'.
                            /* if the current_user is an admin of the fanbase
                            /* or the ORGANIZER of the event, they can delete event */
                            (($isFanbaseAdmin == 1 || $current_user['account_id'] == $fanbaseEvent['account_id']['account_id']) ? 
                                '<form action="deleteEvent.php" method="POST" style="margin:0">
                                    <input type="hidden" name="fanbase_id" value="'.$fanbaseEvent['fanbase_id'].'">
                                    <button class="btn btn-outline-dark" name="deleteEvent" value="'.$fanbaseEvent['event_id'].'" role="button" type="submit">Delete Event</button> 
                                </form>
                                
                                <button class="updateEventBtn btn btn-outline-dark" role="button">Edit</button>'
                            : '')
                        .'
                            </div>
                        </div>
                        <hr>
                        <div class="text"> A '.$fanbaseEvent['event_type'].' Event 
                            <div class="text" style="color:#808080; padding: 0px"> Organizer: '.$fanbaseEvent['account_id']['username'].' </div>
                            <div class="text" style="color:#808080; padding-top: 0px"> Date: '.$fanbaseEvent['event_date'].' Time: '.$fanbaseEvent['event_time'].' Location: '.$fanbaseEvent['event_location'].' </div>
                            '.$fanbaseEvent['event_description'].'
                        </div>

                        <hr>
                        <div class="text" style="display:flex;justify-content:space-between">
                            <div class="text" style="color:#808080; padding: 0px"> Participants: '.$fanbaseEvent['numberOfParticipants'].' </div>
                            <form method="post" action="manageEventParticipant.php">
                                <input type="hidden" name="fanbase_id" value="'.$fanbaseEvent['fanbase_id'].'">
                        '.
                        (($current_user['account_id'] != $fanbaseEvent['account_id']['account_id']) ?
                            (($fanbaseEvent['hasJoined'] == 0) ?
                                '<button type="submit" name="joinEvent" value="'.$fanbaseEvent['event_id'].'" class="btn btn-outline-dark">Join</button>'
                            : '
                            <button type="submit" name="leaveEvent" value="'.$fanbaseEvent['event_id'].'" class="btn btn-outline-dark">Leave</button>')
                        : '')
                    .'      </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }

    return $eventsStr;
}