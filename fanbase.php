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

    mysqli_stmt_bind_result($stmt, $fanbaseName, $fanbaseArtist, $fanbaseDescription);

    mysqli_stmt_fetch($stmt);

    // echo "fanbase name : $fanbaseName <br> fanbase artist : $fanbaseArtist <br> fanbase description : $fanbaseDescription";
    
?>

    <div class="white-container" style="align-items:flex-start; justify-content:space-evenly;">
        <div class="main-container-nopaddings"> 
            <h4 style="font-weight: bold;"> <a href="https://weverse.io/txt/feed"> VIEW LATEST ANNOUNCEMENT (DI PA FINAL) >> </a> </h3>
            <!-- TODO: Href links to latest added event ??? -->
        </div>
    </div>

    <div class="flex-container" atyle="justify-content:space-between;">
        <div>POSTS</div>
        <div>
            <div>GROUP INFO</div>
            <div>MEMBERS COUNT</div>
            <div>EVENTS</div>
        </div>
    </div>

