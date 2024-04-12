<?php
    include("includes/header.php");

    $fanbaseName = $_GET['fanbase'];

    $sqlFanbase = "SELECT * FROM tblFanbase WHERE fanbase_name='".$fanbaseName."'";
    $resultFanbase = $connection->query($sqlFanbase);
    $fanbase = mysqli_fetch_array($resultFanbase);

    // var_dump($fanbase);
?>

<div class="manageAppDiv">
    <h1></h1>
</div>

<footer>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            Charlene Repuesto
            <br>
            BSCS 2
        </a>
    </nav>
</footer>