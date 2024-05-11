<?php

/* fanbase.php */
function getEvents($fanbaseID){
    global $connection, $current_user;

    // getting the member info of the current_user from tbluseraccount_fanbase 
    $sqlCurrFanbaseMember = "SELECT isAdmin FROM tbluseraccount_fanbase WHERE fanbase_id = {$fanbaseID} AND account_id = {$current_user['account_id']}";
    $resMem = mysqli_fetch_array(mysqli_query($connection, $sqlCurrFanbaseMember));
    $isFanbaseAdmin = $resMem['isAdmin'];
    
    // getting ALL events for this fanbase from tblevent
    $sqlevents = "SELECT event_id, e.account_id, username, e.fanbase_id, event_name, event_type, event_date, event_time, event_location, event_description  
                  FROM tblevent as e, tbluseraccount as u 
                  WHERE e.account_id = u.account_id AND fanbase_id = {$fanbaseID}";

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

            /* storing number of event participants */
            $sqlNumParticipants = "SELECT count(event_id) FROM tblevent_participant WHERE event_id = {$row['event_id']}";
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
            <div class="event-container" id="event'.$fanbaseEvent['event_id'].'">        
                <div class="colored-container"> 
                    '.$fanbaseEvent['event_name'].'
                </div>

                <div style="padding: 15px;">
                    <div class="pb-2 border-bottom w-100 d-flex flex-column align-items-center"> 
                        <div>'.$fanbaseEvent['event_type'].'</div>
                        <div class="small-text" style="color:#7c7c7c;"> 
                            <div> Organizer: '.$fanbaseEvent['username'].' </div>
                        </div>
                    </div>
                    <div class="small-text" style="color:#7c7c7c;"> 
                        <div class="d-flex mt-2" style="align-items:center; justify-content:space-between;">
                            <div> Date: '.$fanbaseEvent['event_date'].' </div>  
                            <div> Time: '.$fanbaseEvent['event_time'].' </div>
                        </div>
                        <div> Location: '.$fanbaseEvent['event_location'].' </div>
                        <div> Participants: '.$fanbaseEvent['numberOfParticipants'].'</div>
                    </div>

                    <div class="small-text mt-2" style="word-wrap:break-word">
                        '.$fanbaseEvent['event_description'].' 
                    </div>

                    <div class="d-flex" style="justify-content: space-around; padding:15px">'.
                        (($isFanbaseAdmin == 1 || $current_user['account_id'] == $fanbaseEvent['account_id']) ? 
                            '<form action="php/deleteEvent.php" method="POST" style="margin:0">
                                <input type="hidden" name="fanbase_id" value="'.$fanbaseEvent['fanbase_id'].'">
                                <button class="btn btn-outline-dark" name="deleteEvent" value="'.$fanbaseEvent['event_id'].'" role="button" type="button" id="btnDeleteEvent">Delete Event</button> 
                            </form>
                            
                            <button class="updateEventBtn btn btn-outline-dark" id="E-'.$fanbaseEvent['event_id'].'" role="button">Edit</button>'
                        : 
                            '<form method="post" action="php/manageEventParticipant.php">
                                <input type="hidden" name="fanbase_id" value="'.$fanbaseEvent['fanbase_id'].'">'.
                                (($current_user['account_id'] != $fanbaseEvent['account_id']) ?
                                    (($fanbaseEvent['hasJoined'] == 0) ?
                                        '<button type="submit" name="joinEvent" value="'.$fanbaseEvent['event_id'].'" class="btn btn-outline-dark">Interested</button>'
                                    : '
                                    <button type="submit" name="leaveEvent" value="'.$fanbaseEvent['event_id'].'" class="btn btn-outline-dark">Not Interested</button>')
                                : '')
                            .'</form>'
                        )
                    .'</div>

                </div>
            </div>
        ';
    }

    return $eventsStr;
}
?>

<!-- DELETE EVENT MODAL  -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteEventModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Event</h5>
      </div>
      <div class="modal-body">
        <p> Are you sure you want to delete this event? This action cannot be undone!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
            <button type="submit" name="event_id" class="btn btn-danger"> Delete </button>
      </div>
    </div>
  </div>
</div>