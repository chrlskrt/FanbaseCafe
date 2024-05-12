<?php 
    include("includes/header.php");

    if (!$current_user){
        header("Location: index.php");
        exit();
    }

    $fanbaseID = $_GET["fanbase_ID"];
    $query = "SELECT fanbase_name, fanbase_artist, fanbase_description, fanbase_photo FROM tblfanbase WHERE fanbase_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $fanbaseID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $fanbaseName, $fanbaseArtist, $fanbaseDesc, $fanbasePhoto);

    mysqli_stmt_fetch($stmt);

    $stmt -> close();
    if ($current_user){
        $sqlIsAdmin = "SELECT isAdmin FROM tbluseraccount_fanbase WHERE account_id = {$current_user['account_id']} AND fanbase_id = $fanbaseID";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $sqlIsAdmin));
        
        if ($result){
            $isAdmin = $result['isAdmin'];
        } else {
            $isAdmin = -1;
        }
    }

    $isRequested = 0;
    $isRejected = -1;

    if ($isAdmin == 0){
        $sqlRequest = "SELECT isRequested, isRejected FROM tblfanbase_adminrequest WHERE account_id = {$current_user['account_id']} AND fanbase_id = $fanbaseID";
        $res = mysqli_fetch_assoc(mysqli_query($connection, $sqlRequest));

        if ($res){
            $isRequested = $res['isRequested'];
            $isRejected = $res['isRejected'];
        }
    }
?>

<script src="js/fanbase.js"></script>
<div class="fanbaseBG">
 
<div class="main-container" style="flex-direction:row; justify-content:center; padding-top: 40px;">
    <div style="display:flex; flex:1;">  
        
        <div style="display:flex; flex-direction:column; flex:1">
            <form action="php/createPost.php" method="post">
                <div class="formsch" style="width:auto">
                    <div class="mb-3"> 
                        <div class="text" style="padding-left:15px; padding-bottom:10px; padding-top:0px;"> Welcome back, <?php echo $current_user['username']?>!</div>
                        <input class="form-control" name="post_text" id="btnCreatePost" style="border-radius:18px;" placeholder="What's on your mind?">
                        <label for="post_text"></label>
                    </div>
                    <input type="hidden" name="fanbase_id" value="<?php echo ($fanbaseID) ?>">
                </div>
            </form> 
            
        
            <div class="postevent-container mainFanbaseContent" id="displayPosts">     
                <?php
                    echo getPosts($fanbaseID);
                ?>
            </div>

        </div>

    </div>
    <div style="display:flex; flex:0.8; justify-content:center;">
        <div class="main-container-nopaddings" style="align-items:center">
            <img src="images/grpPhoto/<?php echo "$fanbasePhoto" ?>" style="height: 350px; width:350px; margin-top:3px;"> <br>
            <div class="label" style="font-size: 30px"> <?php echo "$fanbaseArtist" ?> </div> 
            <?php
                if (($current_user['isSysAdmin'] == 1) || ($isAdmin == 1)){
                    echo '<a href="manageFanbase.php?fanbase='.$fanbaseID.'" class="btn btn-outline-dark">Manage Fanbase</a>';
                } else if ($isAdmin == 0 && $isRequested == 0) {
                    echo '
                        <form action="php/requestToBeFanbaseAdmin.php" method="post" class="flex-container">
                            <button type="submit" name="request" value="'.$fanbaseID.'" class="btn btn-outline-dark" style="width:100%">Request To Become Admin</button>
                        </form>
                    '; 
                } else if ($isRequested == 1){
                    echo '
                        <form action="php/requestToBeFanbaseAdmin.php" method="post" class="flex-container">
                            <button type="submit" name="cancelrequest" value="'.$fanbaseID.'" class="btn btn-outline-dark" style="width:100%">Cancel Request To Become Admin</button>
                        </form>
                    ';
                }

                if ($isRejected == 1){
                    echo '
                        <div class="d-flex justify-content-center small-text">Your request to become an admin has been rejected.</div>
                    ';
                }
            ?>

            <button type="submit" id="btnLeaveFanbase" role="button" class="btn btn-outline-danger" style="margin-top:10px"> Leave fanbase? </button>
            
            <div class="post-event-container mainFanbaseContent" id="displayEvents">
                <div class="white-container" style="box-shadow:none; padding-left:10px;padding-right:10px; margin-top: 30px; border-radius:15px;">
                    <div>
                        <div class="label" style="font-size:18px; margin:10px;">WANT TO HOST AN EVENT?</div>
                        <div class="text d-flex justify-content-center" style="padding: 0px"> Create events for the community! </div>
                        
                        <div class="container" style="justify-content: space-around; margin-top: 15px;">
                            <button class="btn btn-outline-dark" type="button" id="btnCreateEvent">Create Event</button>
                        </div>

                    </div>
                </div>
                <?php
                    echo getEvents($fanbaseID);
                ?>
            </div>
        </div>
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


<!-- MODALS -->

<!-- edit event modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editEventModal">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="gap:10px;" role="document">
    <div class="modal-content">
        <div class="modal-header justify-content-center" style="flex-direction:column">
            <h5 class="modal-title">Edit event </h5>
            <div>
                <?php echo '
                    <div class="small-text"> '.$fanbaseName.' </div> 
                ';
                ?>
            </div>
        </div>
        <form action="php/updateEvent.php" method="post" style="margin:0">
            <div class="modal-body updateEventDiv" style="overflow-y:auto">
                <div class="flex-container" style="flex-direction:column; align-items: center; ">
                    <div class="formsch" style="width:95%">
                        <div class="form-floating mb-3"> 
                            <input type="text" class="form-control" name="event_name" id="edit_event_name" placeholder="Enter event name..." required>
                            <label for="event_name">Event Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="event_type" id="edit_event_type" placeholder="Enter event type..." required>
                            <label for="event_type">Event Type</label>
                        </div>
                        <div class="flex-container mb-3" style="gap:4px;">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="edit_event_date" name="event_date" min="<?php echo date("Y-m-d") ?>" required>
                                <label for="event_date">Event Date</label>
                            </div>
                            <div class="form-floating">
                                <input type="time" class="form-control" id="edit_event_time" name="event_time" min="07:00:00" max="20:00:00" required>
                                <label for="event_time">Event Time</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3" style="flex:1">
                            <input type="text" class="form-control" name="event_location" id="edit_event_location" placeholder="Enter event location..." required>
                            <label for="event_location">Event Location</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea rows=4 class="form-control" style="height:max-content" name="event_description" id="edit_event_description" placeholder="Enter event description..." required></textarea>
                            <label for="event_description">Event Description</label>
                        </div>
                        <input type="hidden" name="fanbase_id" value="<?php echo ($fanbaseID) ?>">
                    </div>
                </div>    
            </div>
            <div id="updateEventDivReal">
                <div class="modal-header" style="justify-content:center">
                    Confirm EDIT details
                </div>
                <div class="modal-body" style="overflow-y:auto; height:55vh">
                    <span><b>Event Name: </b><span id="event_name_confirm"></span></span>
                    <br>
                    <span><b>Event Type: </b><span id="event_type_confirm"></span></span>
                    <br>
                    <span><b>Event Date: </b><span id="event_date_confirm"></span></span>
                    <br>
                    <span><b>Event Time: </b><span id="event_time_confirm"></span></span>
                    <br>
                    <span><b>Event Location: </b><span id="event_location_confirm"></span></span>
                    <br>
                    <span><b>Event Description: </b><span id="event_description_confirm"></span></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelEventEdit">Cancel</button>
                    <button id="btnEditEventSubmit" name="event_id" type="submit" role="button" class="btn btn-outline-dark">Update Event details</button>
                </div>
            </div>
        </form>
        
        <div class="modal-footer updateEventDiv">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="updateEventYes" name="event_id" type="button" role="button" class="btn btn-outline-dark">Update Event details</button>
        </div>
    </div>

    <div style="display:flex; align-self:flex-start">
        <button type="button" class="modal-content modal-exit-btn btnCancelEdit" data-bs-dismiss="modal">X</button>
    </div>
  </div>
</div>

<!-- CREATE EVENT REAL -->
<div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" id="createEventModal">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="gap:10px;" role="document">
    <div class="modal-content">
        <div class="modal-header justify-content-center" style="flex-direction:column">
            <h5 class="modal-title"> Create an event </h5>
            <div>
                <?php echo '
                    <div class="small-text"> '.$fanbaseName.' </div> 
                ';
                ?>
            </div>
        </div>
        <form action="./php/createEvent.php" method="post" style="margin:0">
            <div class="modal-body" style="overflow-y:auto">
                <div class="flex-container" style="flex-direction:column; align-items: center; ">
                    <div class="formsch" style="width:95%; justify-content:center;">
                        <div class="form-floating mb-3"> 
                            <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter event name..." required>
                            <label for="event_name">Event Name</label>
                        </div>
                        <div class="mb-3 flex-container" style="gap: 10px">
                            <select name="event_type" id="event_type" class="form-select" style="flex:1" aria-label="Choose Event Type" required>
                                <option value="">Choose an Event Type</option>
                                <option value="Meet & Greet">Meet & Greet</option>
                                <option value="Cupsleeve">Cupsleeve</option>
                                <option value="Fan Festival">Fan Festival</option>
                                <option value="Fan Concert">Fan Concert</option>
                                <option value="Watch Party / Screening">Watch Party / Screening</option>
                            </select>
                        </div>
                        <div class="flex-container mb-3" style="gap:4px; justify-content:space-evenly; align-items:flex-start">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="event_date" name="event_date" min="<?php echo date("Y-m-d") ?>" required>
                                <label for="event_date">Event Date</label>
                            </div>
                            <div class="form-floating">
                                <input type="time" class="form-control" id="event_time" name="event_time" min="07:00:00" max="20:00:00" required>
                                <label for="event_time">Event Time</label>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="event_location" id="event_location" placeholder="Enter event location..." required>
                            <label for="event_location">Event Location</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea rows=4 class="form-control" name="event_description" style="height:max-content" id="event_description" placeholder="Enter event description..." required></textarea>
                            <label for="event_description">Event Description</label>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <input type="hidden" name="fanbase_id" value="<?php echo ($fanbaseID) ?>">
                <button id="btnCreateEventSubmit" value="1" type="submit" role="button" class="btn btn-outline-dark">Create Event</button>
            </div>
        </form>
    </div>

    <div style="display:flex; align-self:flex-start">
        <button type="button" class="modal-content modal-exit-btn" data-bs-dismiss="modal">X</button>
    </div>
  </div>
</div>

<?php
    if (isset($_GET['post'])){
        echo '<script type="module" >
                import { viewModal } from "./js/misc.js"
                $(function(){
                    $(window).scrollTop($("#post'.$_GET['post'].'").offset().top);
                    viewModal('.$_GET["post"].');
                });
            </script>';
    }
?>

<!-- view post modal  -->
<div class="modal fade" tabindex="-1" data-bs-backdrop="static" role="dialog" id="viewPostModal" style="z-index: 1062 !important">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="gap:10px;" role="document">
    <div class="modal-content" style="height:92vh;">
        <div class="modal-header" style="margin-left:15px; padding:25px; padding-right:15px; align-items:flex-start">
            <div id="postBody" style="display:flex; flex:1"></div>
            <button type="button" name="post_id" id="modalDeletePost" value="" class="btn btn-outline-light btnDeletePost">🗑️</button>
        </div>
        <div class="modal-body" id="postReplies" style="flex:1; overflow-y:auto;">
        </div>
            <form id="createReplyForm" style="margin:0">
            <div class="modal-footer" id="postCreateReply">
                    <div class="formsch" style="width:100%">
                        <div class="mb-3 from-group" style="display:flex; gap:10px"> 
                            <textarea class="form-control" id="createReplyInput" name="reply_text" placeholder="Write something..." required></textarea>
                            <input type="hidden" name="fanbase_ID" id="createReply_fanbaseID">
                            <button name="post_id" class="btn btn-outline-dark" id="createReply_postID">Reply</button>
                        </div>
                    </div>
            </div>
        </form>
    </div>

    <div style="display:flex; align-self:flex-start">
        <button value="" id="viewPostExitBtn" class="modal-content modal-exit-btn">X</button>
    </div>
  </div>
</div>

<!-- CREATE POST MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" id="createPostModal">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="gap:10px;" role="document">
    <div class="modal-content">
        <div class="modal-header" style="justify-self:center; flex-direction: column">
            <h5 class="modal-title"> Write a post </h5>
            <div>
                <?php echo '
                    <div class="small-text"> '.$fanbaseName.' </div> 
                ';
                ?>
            </div>
        </div>

        <form action="php/createPost.php" method="post" style="margin:0">
            <div class="modal-body" style="overflow-y:auto">
                <div class="flex-container" style="flex-direction:column; align-items: center; ">
                    <div class="formsch" style="width:95%; outline:none;">
                    <div data-mdb-input-init class="form-outline">
                        <textarea class="form-control" name="post_text" id="post_text" rows="15"></textarea>
                    </div>
                        <input type="hidden" name="fanbase_id" value="<?php echo ($fanbaseID) ?>">
                    </div>
                </div>    
            </div>
            <div class="modal-footer">
                <button id="btnCreatePostSubmit" value="1" type="submit" role="button" class="btn btn-outline-dark btn-lg">Post</button>
            </div>
        </form>
        
    </div>

    <div style="display:flex; align-self:flex-start">
        <button type="button" class="modal-content modal-exit-btn" data-bs-dismiss="modal">X</button>
    </div>
  </div>
</div>

<!-- LEAVE FANBASE MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="leaveFanbaseModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Leave Fanbase</h5>
        </div>
        <div class="modal-body">
            <p> Are you sure? This action cannot be undone! </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
            <form action="php/leaveFanbase.php" method="POST">
                <input type="hidden" value="<?php echo $fanbaseID ?>" name="fanbaseID">
                <button type="submit" role="button" value="<?php echo $current_user["account_id"] ?>" name="leaveFanbaseMember" class="btn btn-outline-danger"> Leave </button>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- DELETE EVENT MODAL -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteEventModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete Event</h5>
        </div>
        <div class="modal-body">
            <p> Are you sure? This action cannot be undone! </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel </button>
            <form action="php/deleteEvent.php" method="POST">
                <input type="hidden" value="<?php echo $fanbaseID ?>" name="fanbase_id">
                <button id="btnDeleteEventConfirm" name="deleteEvent" type="submit" role="button" class="btn btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- DELETE POST MODAL  -->
<div class="modal fade importantModal" tabindex="-2" data-bs-backdrop="static" role="dialog" id="deletePostModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Post</h5>
      </div>
      <div class="modal-body">
        <p> Are you sure you want to delete this post?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnDeleteCancel" data-bs-dismiss="modal"> Cancel </button>
        <form method="POST" action="php/deletePost.php">
            <input type="hidden" name="fanbase_id" value="<?php echo $fanbaseID ?>">
            <button id="btnDeletePostConfirm" type="submit" name="post_id" value="" class="btn btn-danger"> Delete </button>
        </form>
      </div>
    </div>
  </div>
</div>