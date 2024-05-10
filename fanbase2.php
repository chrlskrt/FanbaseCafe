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

<div class="announcement-container">
    "Wish to become admin? [ Request Admin Button ]" OR "Edit or Update details? [ Manage Fanbase ]"
    <div>
        <?php
                if (($current_user && $current_user['isSysAdmin'] == 1) || ($current_user && $isAdmin == 1)){
                    echo '<a href="manageFanbase.php?fanbase='.$fanbaseName.'" class="btn btn-outline-dark">Manage Fanbase</a>';
                } else if ($isAdmin == 0) {
                    echo '
                        <form action="requestToBeFanbaseAdmin.php" method="post">
                            <button type="submit" name="fanbase_id" value="'.$fanbaseID.'" class="btn btn-outline-dark">Request To Become Admin</button>
                        </form>
                    ';
                }
        ?>
    </div>
</div>

<div class="main-container" style="flex-direction:row; justify-content:center; padding-top: 40px;">
    <div style="display:flex; flex:1; width: 70%;">  
        
        <div>

            <textarea class="form-control mb-3 formsch" id="createPost" placeholder="What's on your mind?" required></textarea>
            <button type="button" class="btn btn-outline-dark" id="btnCreatePost">Create Post</button>
        
            <div class="event-container" style="border-radius: 15px; padding: 20px;">
                g rato ang pikas, icopy paste nlng tong modal2?? chuhcu sa getPost chuchuchu
            </div>

        </div>
        
    </div>
    <div style="display:flex; flex:0.8; justify-content:center; width: 30%;">
        <div class="main-container-nopaddings">
            <img src="images/grpPhoto/grp<?php echo "$fanbaseName" ?>.jpg" style="height: 350px; width:350px;"> <br>
            <div class="label" style="font-size: 30px"> <?php echo "$fanbaseArtist" ?> </div> 
            <?php echo '<a href="manageFanbase.php?fanbase='.$fanbaseName.'" class="btn btn-outline-dark">Manage Fanbase</a>' ?> <br>
            
            <!-- EVENT DIV CHUCHU START -->

            <div class="event-container" style="flex-direction:column; border-radius:15px; margin-top: 30px"> 
            
                <div class="colored-container"> 
                    <div>SVT CEBU MEET & GREET</div>
                </div>

                <div style="padding: 15px;">
                    <div class="pb-2 border-bottom w-100 d-flex flex-column align-items-center"> 
                        <div> Event Type</div>
                        <div class="small-text" style="color:#7c7c7c;"> 
                            <div> Organizer: bbgirl </div>
                        </div>
                    </div>
                    <div class="small-text" style="color:#7c7c7c;"> 
                        <div class="d-flex mt-2" style="align-items:center; justify-content:space-between;">
                            <div> Date: April 16, 2024 </div>  
                            <div> Time: 2:46pm </div>
                        </div>
                        <div> Location: BBGIRLS </div>
                        <div> Participants: 7</div>
                    </div>

                    <div class="small-text mt-2">
                        magcuddle sa seaside with bbgirl 
                    </div>

                    <div class="d-flex flex-column justify-content-center align-items-center" style="padding:15px">
                        [ JOIN / BUTTONS ]
                    </div>

                </div>
            </div>

            <!-- EVENT DIV END CHUCHU  -->

            <!-- EVENT 2 -->
            <div class="event-container" style="flex-direction:column; border-radius:15px; margin-top: 30px"> 
            
                <div class="colored-container"> 
                    <div>SVT CEBU MEET & GREET</div>
                </div>

                <div style="padding: 15px;">
                    <div class="pb-2 border-bottom w-100 d-flex flex-column align-items-center"> 
                        <div> Event Type</div>
                        <div class="small-text" style="color:#7c7c7c;"> 
                            <div> Organizer: bbgirl </div>
                        </div>
                    </div>
                    <div class="small-text" style="color:#7c7c7c;"> 
                        <div class="d-flex mt-2" style="align-items:center; justify-content:space-between;">
                            <div> Date: April 16, 2024 </div>  
                            <div> Time: 2:46pm </div>
                        </div>
                        <div> Location: BBGIRLS </div>
                        <div> Participants: 7</div>
                    </div>

                    <div class="small-text mt-2">
                        magcuddle sa seaside with bbgirl 
                    </div>

                    <div class="d-flex flex-column justify-content-center align-items-center" style="padding:15px">
                        [ JOIN / BUTTONS ]
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

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

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Charlene Repuesto and Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>