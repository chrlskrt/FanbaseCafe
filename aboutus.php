<?php
    include("connect.php");
    require_once("includes/header.php");
?>

<div class="fanbaseBanner">
    <img src="images/mainBanner2.png" style="width:100%;">
    <div class="centeredBanner-text">
        <div class="label" style="color:white; font-size: 9vw;">ABOUT US</div>
    </div>
</div>
 
<?php
$sqluser = "SELECT user_id FROM tbluseraccount";
$sqlfanbase = "SELECT fanbase_id FROM tblfanbase";
 
$resultuser = $connection->query($sqluser);
$resultfanbase = $connection->query($sqlfanbase);
 
$usercount = mysqli_num_rows($resultuser);
$fanbasecount = mysqli_num_rows($resultfanbase);
 
echo '
<div class="flex-container" style=" padding: 30px">
    <div class="label" style="font-size: 40px;"> NUMBER OF USERS: '." $usercount ".' </div>
    <div class="label" style="font-size: 40px;"> NUMBER OF FANBASES: '." $fanbasecount ".' </div>
</div>
';
 
?>

<div id="about_us" class="flex-container" style="flex-direction: column; padding: 40px">
    <!-- <div class="label"> ABOUT US </div> -->
    <hr>
    <div style="text-align: center;"> We are passionate towards our favorite idols, and same goes for other fellow fans as well!
        We here at Fanbase Cafe, aim to connect people with similar interests across the globe, build communities
        and support our favorite K-pop groups as one. Founded in 2024, our goal is to reach more people of different
        backgrounds and continue to strive as one to be a token for K-pop fans. </div>
</div>

<div class="flex-container" style="flex-direction: column; padding: 40px;"> 
    <div class="label" style="font-size: 40px;"> FOUNDERS </div>
    <hr>
</div>

<div class="main-container" style="margin-bottom: 20px;">
    <div class="flex-container">
        <div class="white-container">
            <img src="images/umji.jpg" class="tile-image">

            <div class="main-container-nopaddings">
                <b> Angel Cambarijan </b>
                <div class="text"> I always enjoy meeting new people, whether online or offline. There are a lot of applications and websites
                    that lets you socialize and step out of your comfort zone, and the joy of having long hours of conversation about common interests never
                    seemed to die down. It should come as no surprise that one of those interests is about K-pop! 
                    I've decided to create my own website together with my partner and co-founder, that will share that sort of memory with many more. </div>
                <div class="socialmedia-container">
                    <img src="images/facebook.png" class="socialmedia-logo">
                    <img src="images/instagram.png" class="socialmedia-logo">
                </div>

            </div>
        </div>
    </div>
</div>

<div class="main-container" style="margin-bottom: 20px;">
    <div class="flex-container">
        <div class="white-container">
            <img src="images/jisoo.jpg" class="tile-image">

            <div class="main-container-nopaddings">
                <b> Charlene Repuesto </b>
                <div class="text"> I've been a big fan of K-pop for a long time now, to the point I collect albums, photocards, and
                    whatever merch I can get my hands on. The community is such a big place, and I know for sure a lot of others feel the 
                    same feeling of accomplishment and happiness when I see my well-earned merch in my room. I wish that this website will
                    serve as another place for fans to share their treasures and be a one wholehearted environment for everyone! </div>

                <div class="socialmedia-container">
                    <img src="images/facebook.png" class="socialmedia-logo">
                    <img src="images/instagram.png" class="socialmedia-logo">
                </div>

            </div>
        </div>
    </div>
</div>

<div id="contact_us" class="flex-container" style="flex-direction: column; padding:40px;">
    <div class="label" style="font-size: 40px;"> CONTACT US </div>
    <div style="text-align: center;"> Get in touch and let us know how we can help. </div>
    <hr>
</div>

<div class="main-container" style="margin: 0px 40px 40px 40px;">
    <div class="flex-container" style="text-align:center; align-items:flex-start"> 
        <div> 
            <div class="main-container-nopaddings">
                <div class="text" style="font-weight: bold;"> MEDIA CONTACTS </div>
                <div class="text" style="padding-top:0%;"> 
                Please email your detailed inquiry and deadline for response to the following: <br>
                angelcambarijan@gmail.com <br>
                charlenerepuesto@gmail.com</div>
            </div>
        </div> 

        <div> 
            <div class="main-container-nopaddings">
                <div class="text" style="font-weight: bold;"> CUSTOMER SERVICE </div>
                <div class="text" style="padding-top:0%;"> If you have general questions or concerns about Fanbase Cafe, please contact our Customer Contact Center 
                <i> customerservice.fanbasecafe.com. </i> </div>
            </div>
        </div> 

        <div> 
            <div class="main-container-nopaddings">
                <div class="text" style="font-weight: bold;"> INVESTOR RELATIONS </div>
                <div class="text" style="padding-top:0%;"> For inquiries related to stock ownership please submit a written inquiry through email to 
                <i> investorrelations@fanbasecafe.com. </i> </div>
            </div>
        </div> 
    </div>
</div>



<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Angel Sheinen O. Cambarijan
            <br>
            BSCS 2
        </a>
    </nav>
</footer>
