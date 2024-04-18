<?php 
    include("includes/header.php");
?>

<!-- <div class="container">
    <p id="welcome_text">Welcome to Fanbase Cafe</p>
</div> -->

<div class="fanbaseBanner">
    <img src="images/mainBanner1.png" style="width:100%;">
    <div class="centeredBanner-text">
        <!-- <div class="label" style="color:white; text-align:left;">Transforming Fan Experiences</div> -->
        <div class="label" style="color:white; text-align:left;font-size: 6vw;">Transforming Fan Experiences</div>
        <h5>Connecting people across fandoms</h5>
    </div>
</div>

<div class="main-container">
  <div>
    <br><h3> <b> POPULAR FANBASES </b> </h3>
  </div>


  <?php 

    function displayFanbases() {
      global $connection;

        $sqlfanbase = "SELECT * FROM tblfanbase";
        $resultfanbase = mysqli_query($connection, $sqlfanbase);
        
        $fanbaseArray = array();

        if ($resultfanbase){
            /* query is a success
            /* looping thru every row of record sa tblfanbase */
            while ($row = $resultfanbase->fetch_assoc()) {
                /* $row = 1 fanbase entry
                /* iadd siya sa fanbase array */
                $fanbaseArray[] = $row;
            } 

            $resultfanbase->free(); // freeing result set
        }

        $fanbaseCard = NULL;

        foreach($fanbaseArray as $fanbase) {
          $fanbaseCard .= '
          
          <a href="fanbase.php?fanbase_ID='.$fanbase['fanbase_id'].'" class="card2">
            <img src="images/grp'.$fanbase['fanbase_name'].'.jpg" class="card2-img">
            <div class="cardContent">
              <img src="images/grp'.$fanbase['fanbase_name'].'Logo.jpg" class="card2-logo"> 
              <p class="card2-name">'.$fanbase['fanbase_artist'].' </p>
            </div>
          </a>

          ';
        }

        return $fanbaseCard;
    }
  ?>

  <div class="flex-container fanbases" style="justify-content:start; ">

  <?php echo displayFanbases(); ?>
    
  <!-- <form action="fanbase.php" method="GET">
    <div class="card2">
      <img src="images/grpcarat.jpg" class="card2-img">
      <div class="cardContent">
        <img src="images/grpsvtLogo.jpg" class="card2-logo"> 
         <p class="card2-name">SEVENTEEN</p>
         <button type="submit" role ="button" value="1" name="fanbase_ID"> View Fanbase </button>
      </div>
    </div>
</form> -->

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