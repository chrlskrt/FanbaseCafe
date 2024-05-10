<?php 
    include("includes/header.php");

    $fanbaseID = $_GET["fanbase_ID"];
    $query = "SELECT fanbase_name, fanbase_artist, fanbase_description, fanbase_photo FROM tblfanbase WHERE fanbase_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $fanbaseID);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $fanbaseName, $fanbaseArtist, $fanbaseDesc, $fanbasePhoto);

    mysqli_stmt_fetch($stmt);

    $stmt -> close();
?>

<div class="flex-container" style="flex-direction: column; padding: 40px;"> 
    <img src="images/grpPhoto/<?php echo $fanbasePhoto ?>" style="height: 800px; width:800px;">
    <div class="label" style="font-size: 40px; padding: 30px;"> 
        <?php echo "$fanbaseArtist" ?> 
    </div>

    <hr>
    
    <div class="text" style="font-weight:bold;">
        <?php
            $sqlTotalMember = "SELECT count(acc_fanbase_id) as totalMemberCount FROM tbluseraccount_fanbase
            WHERE fanbase_id = {$fanbaseID}";

            $sqlResult = mysqli_fetch_assoc(mysqli_query($connection,$sqlTotalMember,))['totalMemberCount'];

        echo "$fanbaseDesc <br>
            Total Member count: $sqlResult"; 
            
            ?> 
    </div>

    <?php 
        if ($current_user){
            echo displayButton();
        }
    ?>
</div>

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
            header("Location:fanbase.php?fanbase_ID={$fanbaseID}");
            exit();
        }

        return $joinStr;
    }
?>

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>