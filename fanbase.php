<?php 
    include("includes/header.php");
    $fanbaseID = $_GET["fanbase_ID"];
    // echo "test fanabse id: {$fanbaseID}<br>";

    $query = "SELECT fanbase_name, fanbase_artist, fanbase_description FROM tblfanbase WHERE fanbase_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $fanbaseID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $fanbaseName, $fanbaseArtist, $fanbaseDesc);

    mysqli_stmt_fetch($stmt);

    $stmt -> close();
    // echo "fanbase name : $fanbaseName <br> fanbase artist : $fanbaseArtist <br> fanbase description : $fanbaseDescription";
    
?>

<script src="js/fanbase.js"></script>

    <div class="white-container" style="align-items:flex-start; justify-content:space-evenly;">
        <div class="main-container-nopaddings"> 
            <h4 style="font-weight: bold;"> <a href="https://weverse.io/txt/feed"> VIEW LATEST ANNOUNCEMENT (DI PA FINAL) >> </a> </h4>
            <!-- TODO: Href links to latest added event ??? -->
        </div>
    </div>

    <div class="flex-container" style="flex-direction: column; padding: 40px;"> 
        <img src="images/grp<?php echo "$fanbaseName" ?>.jpg" style="height: 800px; width:800px;">
        <div class="label" style="font-size: 40px; padding: 30px;"> 
            <?php echo "$fanbaseArtist" ?> 
            <div class="text" style="padding: 0px;">
                <a href="manageFanbase.php?fanbase=<?php echo ($fanbaseName) ?>" class="btn btn-outline-dark">Manage Fanbase</a>
            </div>
        </div>

        <hr>
        
        <div class="text" style="font-weight:bold;">
            <?php
            echo "$fanbaseDesc <br>
                Total Member count:" ?> 
        </div>
        <form action="joinFanbase.php" method="POST">
            <input type="hidden" value="<?php echo $fanbaseID ?>" name="fanbaseID">
            <button type="submit" role="button" value="<?php echo ($current_user['account_id']) ?>" name="fanbaseMember"> Join now! </button>
        </form>

        <form action="leaveFanbase.php" method="POST">
            <input type="hidden" value="<?php echo $fanbaseID ?>" name="fanbaseID">
            <button type="submit" role="button" value="<?php echo ($current_user['account_id']) ?>" name="leaveFanbaseMember"> Leave fanbase? </button>
        </form>
    </div>

    <hr>

    <div class="manageAppDiv">
        <div class="container" style="justify-content: space-around">
            <button type="button" class="btn btn-outline-dark" id="btnCreateEvent">Create Event</button>
            <button type="button" class="btn btn-outline-dark" id="btnCreatePost">Create Post</button>
        </div>

        <div class="flex-container" id="createEventDiv" style="flex-direction:column; align-items: center;">
            <a class="btn label" id="createFanbaseDiv" style="font-size: 20px;">[ Create Event ]</a>
            <form action="createEvent.php" method="post">
                <div class="formsch">
                    <div class="form-floating mb-3"> 
                        <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter event name..." required>
                        <label for="event_name">Event Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="event_type" id="event_type" placeholder="Enter event type..." required>
                        <label for="event_type">Event Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="event_date" name="event_date" min="<?php echo date("Y-m-d") ?>" required>
                        <label for="event_date">Event Date</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="time" class="form-control" id="event_time" name="event_time" min="07:00:00" max="20:00:00" required>
                        <label for="event_time">Event Time</label>
                        <p style="color:red; font-size:.5vw" id="errorTime"></p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="event_location" id="event_location" placeholder="Enter event location..." required>
                        <label for="event_location">Event Location</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="event_description" id="event_description" placeholder="Enter event description..." required></textarea>
                        <label for="event_description">Event Description</label>
                    </div>
                    <input type="hidden" name="fanbase_id" value="<?php echo ($fanbaseID) ?>">
                    <button id="btnCreateEventSubmit" value="1" type="submit" role="button" class="btn btn-outline-dark btn-lg btn-block">Create Event</button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <div class="manageAppDiv" id="displayEvents">
        <div class="label" style="font-size: 20px; justify-content:flex-start">Events</div>
        
        <div style="display: flex; flex-direction:column; gap: 10px; justify-content: center;">
            <?php
                echo displayEvents();
            ?>
        </div>
    </div>

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Charlene Repuesto and Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>


<?php
    function displayEvents(){
        global $connection, $fanbaseID;

        // getting ALL events for this fanbase from tblevent
        $sqlevents = "SELECT * FROM tblevent WHERE fanbase_id = {$fanbaseID}";
        $resultevents = mysqli_query($connection, $sqlevents);
        
        // creating an empty array
        $fanbaseEventsArr = array();

        if ($resultevents){
            /* query is a success
            /* looping thru every row of record sa tblfanbase */
            while ($row = $resultevents->fetch_assoc()) {
                /* $row = 1 fanbase entry
                /* iadd siya sa fanbase array */
                $row['event_date'] = date_format(date_create($row['event_date']), "F d, Y");
                $row['event_time'] = date_format(date_create($row['event_time']), "g:i A");
                $fanbaseEventsArr[] = $row;
            } 

            $resultevents->free(); // freeing result set
        }

        $eventsStr = '';
        foreach ($fanbaseEventsArr as $fanbaseEvent) {
            $eventsStr .= '
                <div class="flex-container">
                    <div class="white-container">
                        <div class="main-container-nopaddings">
                            <b>'.$fanbaseEvent['event_name'].'</b>
                            <hr>
                            <div class="text"> A '.$fanbaseEvent['event_type'].' Event 
                                <div class="text" style="color:#808080"> Date: '.$fanbaseEvent['event_date'].' Time: '.$fanbaseEvent['event_time'].' Location: '.$fanbaseEvent['event_location'].' </div>
                                '.$fanbaseEvent['event_description'].'
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        return $eventsStr;
    }
?>