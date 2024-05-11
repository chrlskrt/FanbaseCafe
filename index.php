<?php 
    include("includes/header.php");
?>

<div class="fanbaseBanner">
  <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="images/mainBanner1.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item active">
          <img src="images/mainBanner3.png" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item active">
          <img src="images/mainBanner4.png" class="d-block w-100" alt="...">
        </div>
    </div>
  </div>
    <div class="centeredBanner-text">
        <div class="label" style="color:white; text-align:left;font-size: 6vw;">
          Transforming Fan Experiences
        </div>
        <h5>Connecting people across fandoms</h5>
    </div>
</div>

<div class="main-container" style="margin-right:55px;">
  <div>
    <br><h3> <b> POPULAR FANBASES </b> </h3>
  </div>

  <div class="flex-container fanbases" style="justify-content:flex-start; ">
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