<?php 
    include("includes/header.php");
?>

<?php
    $fanbaseID = $_GET["fanbase_ID"];
    // echo "test fanabse id: {$fanbaseID}<br>";

    $query = "SELECT fanbase_name, fanbase_artist, fanbase_description FROM tblfanbase WHERE fanbase_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $fanbaseID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $fanbaseName, $fanbaseArtist, $fanbaseDesc);

    mysqli_stmt_fetch($stmt);

    // echo "fanbase name : $fanbaseName <br> fanbase artist : $fanbaseArtist <br> fanbase description : $fanbaseDescription";
    
?>

    <div class="white-container" style="align-items:flex-start; justify-content:space-evenly;">
        <div class="main-container-nopaddings"> 
            <h4 style="font-weight: bold;"> <a href="https://weverse.io/txt/feed"> VIEW LATEST ANNOUNCEMENT (DI PA FINAL) >> </a> </h4>
            <!-- TODO: Href links to latest added event ??? -->
        </div>
    </div>

    <div class="flex-container" style="flex-direction: column; padding: 40px;"> 
        <div class="label" style="font-size: 40px;"> 
            <img src="images/grp<?php echo "$fanbaseName" ?>.jpg">
            <?php echo "$fanbaseArtist" ?> 
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
    </div>

    <div class="flex-container" atyle="justify-content:space-between;">
        
        <div>POSTS</div>
        <div>
            <div>GROUP INFO</div>
            <div>MEMBERS COUNT</div>
            <div>EVENTS</div>
        </div>
    </div>
