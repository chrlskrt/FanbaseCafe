<?php 
    include("includes/header.php");
?>

<div class="fanbaseBanner">
    <img src="images/mainBanner1.png" style="width:100%;">
    <div class="centeredBanner-text">
        <div class="label" style="color:white; text-align:left;font-size: 6vw;">Transforming Fan Experiences</div>
        <h5>Connecting people across fandoms</h5>
    </div>
</div>

<div class="main-container">
  <div>
    <br><h3> <b> POPULAR FANBASES </b> </h3>
  </div>

  <div class="flex-container fanbases" style="justify-content:start; ">
    <?php echo getFanbases(); ?>
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