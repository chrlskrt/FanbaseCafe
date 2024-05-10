<?php 
    include("includes/header.php");

    $fanbaseID = $_GET["fanbase_ID"];
    $query = "SELECT fanbase_name, fanbase_artist, fanbase_description FROM tblfanbase WHERE fanbase_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $fanbaseID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $fanbaseName, $fanbaseArtist, $fanbaseDesc);

    mysqli_stmt_fetch($stmt);

    $stmt -> close();
    $isAdmin = 0;
    if ($current_user){
        $sqlIsAdmin = "SELECT isAdmin FROM tbluseraccount_fanbase WHERE account_id = {$current_user['account_id']} AND fanbase_id = $fanbaseID";
        $result = mysqli_fetch_assoc(mysqli_query($connection, $sqlIsAdmin));
        
        if ($result){
            $isAdmin = $result['isAdmin'];
        } else {
            $isAdmin = -1;
        }
         
    }
?>

<script src="js/fanbase.js"></script>

<div class="white-container" style="align-items:flex-start; justify-content:space-evenly;">
    <div class="main-container-nopaddings"> 
        <h4 style="font-weight: bold;"> <a href="https://weverse.io/txt/feed"> VIEW LATEST ANNOUNCEMENT (DI PA FINAL) >> </a> </h4>
        <!-- TODO: Href links to latest added event ??? -->
    </div>
</div>

<div class="flex-container" style="flex-direction: column; padding: 40px;"> 
    <img src="images/grpPhoto/grp<?php echo "$fanbaseName" ?>.jpg" style="height: 800px; width:800px;">
    <div class="label" style="font-size: 40px; padding: 30px;"> 
        <?php echo "$fanbaseArtist" ?> 
        <div class="text" style="padding: 0px;">
            <?php
                if (($current_user && $current_user['isSysAdmin'] == 1) || ($current_user && $isAdmin == 1)){
                    echo '<a href="manageFanbase.php?fanbase='.$fanbaseName.'" class="btn btn-outline-dark">Manage Fanbase</a>';
                } else if ($isAdmin == 0) {
                    echo '
                        <form action="php/requestToBeFanbaseAdmin.php" method="post">
                            <button type="submit" name="fanbase_id" value="'.$fanbaseID.'" class="btn btn-outline-dark">Request To Become Admin</button>
                        </form>
                    ';
                }
            ?>
        </div>
    </div>

    <hr>
    
    <div class="text" style="font-weight:bold;">
        <?php
        echo "$fanbaseDesc <br>
            Total Member count:" ?> 
    </div>

    <?php 
        if ($current_user){
            echo displayButton();
        }
    ?>
</div>

<section id="mainFanbaseContent" style="display:flex; flex-direction:column;">
    <hr>
    <div class="manageAppDiv">
        <div class="container" style="justify-content: space-around">
            <button type="button" class="btn btn-outline-dark" id="btnCreateEvent">Create Event</button>
            <button type="button" class="btn btn-outline-dark" id="btnCreatePost">Create Post</button>
        </div>

        <div class="flex-container" id="createEventDiv" style="flex-direction:column; align-items: center;">
            <a class="btn label" style="font-size: 20px;">[ Create Event ]</a>
            <form action="./php/createEvent.php" method="post">
                <div class="formsch">
                    <div class="form-floating mb-3"> 
                        <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter event name..." required>
                        <label for="event_name">Event Name</label>
                    </div>
                    <div class="mb-3 flex-container" style="gap: 10px">
                        <label for="event_type">Event Type</label>
                        <select name="event_type" id="event_type" class="form-select" style="flex:1" aria-label="Choose Event Type" required>
                            <option value="">Choose an Event Type</option>
                            <option value="Meet & Greet">Meet & Greet</option>
                            <option value="Cupsleeve">Cupsleeve</option>
                            <option value="Fan Festival">Fan Festival</option>
                            <option value="Fan Concert">Fan Concert</option>
                            <option value="Watch Party / Screening">Watch Party / Screening</option>
                        </select>
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

        <div class="flex-container" id="createPostDiv" style="flex-direction:column; align-items: center;">
            <a class="btn label" style="font-size: 20px;">[ Create Post ]</a>
            <form action="php/createPost.php" method="post">
                <div class="formsch">
                    <div class="mb-3"> 
                        <textarea class="form-control" name="post_text" id="post_text" placeholder="Write something..." required></textarea>
                        <label for="post_text"></label>
                    </div>
                    <input type="hidden" name="fanbase_id" value="<?php echo ($fanbaseID) ?>">
                    <button id="btnCreatePostSubmit" value="1" type="submit" role="button" class="btn btn-outline-dark btn-lg">Post</button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <div class="manageAppDiv" id="displayEvents" style="align-items: center;">
        <div class="label" style="font-size: 20px; justify-content:flex-start">Events</div>
        
        <div style="display: flex; flex-direction:column; gap: 10px; justify-content: center; align-items: center; width: 75vw;">
            <?php
                echo getEvents($fanbaseID);
            ?>
        </div>
    </div>

    <div class="manageAppDiv" id="displayPosts" style="align-items: center;">
        <div class="label" style="font-size: 20px; justify-content:flex-start">Posts</div>
        
        <div style="display: flex; flex-direction:column; gap: 10px; justify-content: center; width: 80vw;">
            <?php
                echo getPosts($fanbaseID);
            ?>
        </div>
    </div>
</section>

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
    function displayButton(){
        global $connection, $fanbaseID, $current_user;

        $sqlfanbase = "SELECT isMember FROM tbluseraccount_fanbase WHERE fanbase_id = {$fanbaseID} AND account_id = {$current_user['account_id']}";
        $sqlResult = mysqli_query($connection, $sqlfanbase);

        $joinStr = NULL;
        if(mysqli_num_rows($sqlResult) == 0 || mysqli_num_rows($sqlResult) == 1 && mysqli_fetch_assoc($sqlResult)['isMember'] == 0) {
            $joinStr .= '
            <form action="php/joinFanbase.php" method="POST">
                <input type="hidden" value="'.$fanbaseID.'" name="fanbaseID">
                <button type="submit" id="btnJoinFanbase" role="button" value="'.($current_user["account_id"]).'" name="fanbaseMember" class="btn btn-outline-dark"> Join now! </button>
            </form>
        ';
        } else {
            $joinStr .= '
            <form action="php/leaveFanbase.php" method="POST">
                <input type="hidden" value="'.$fanbaseID.'" name="fanbaseID">
                <button type="submit" id="btnLeaveFanbase" role="button" value="'.($current_user["account_id"]).'" name="leaveFanbaseMember" class="btn btn-outline-dark"> Leave fanbase? </button>
            </form>
            ';
        }

        return $joinStr;
    }
?>

<!-- MODALS -->

<!-- WRITE POST MODAL START -->
<div class="modal fade" tabindex="-1" role="dialog" id="createPostModal">
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
            <div class="modal-body" style="height:74vh; overflow-y:auto">
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
  </div>
</div>
<!-- WRITE POST MODAL END -->


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
<div class="modal fade" tabindex="-1" role="dialog" id="viewPostModal">
  <div class="modal-dialog modal-dialog-centered modal-lg" style="gap:10px;" role="document">
    <div class="modal-content" style="height:92vh;">
        <div class="modal-header">
            <div id="postBody" style="width:100%; margin-left:15px"></div>
        </div>
        <div class="modal-body" id="postReplies" style="flex:1; overflow-y:auto"></div>
        <!-- <form action="createReply.php" method="post" style="margin:0"> -->
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
        <button id="viewPostExitBtn" type="button" class="btn btn-outline-light" data-bs-dismiss="modal">X</button>
    </div>
  </div>
</div>