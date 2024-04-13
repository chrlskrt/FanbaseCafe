<head>
<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- JQUERY CDN LINKS  -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    
    <!-- BOOTSTRAP CDN LINKS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <link href="css/styles.css" rel="stylesheet" />
</head>

<header>
    <nav class="navbar">
        <section>
            <a class="navbar-brand" href="#">
                <div class="label" style="font-size: 20px;"> Fanbase Cafe 
                    <a href="index.php" class="btn btn-outline-light">Home</a>
                </div>
            </a>
        </section>
        <section>
            <!-- /* if naa nay concept na log-out pd nani siya on the go yesyes */ -->
            <?php
                include_once("api.php");
                if($current_user == null){
                    echo '<a href="register.php" class="btn btn-outline-light">Register</a>
                    <a href="login.php" class="btn btn-outline-light">Log In</a>';
                } 
            ?>
            
            <!-- <a href="register.php" class="btn btn-outline-light">Sign Up</a>
            <a href="login.php" class="btn btn-outline-light ">Log In</a> -->
            <a href="aboutus.php" class="btn btn-outline-light">About Us</a>
            <a href="aboutus.php#contact_us" class="btn btn-outline-light">Contact Us</a>
            
            <?php
                if($current_user){
                    if ($current_user['isSysAdmin'] == 1){
                        echo '<a href="manageApp.php" class="btn btn-outline-light">Manage App</a> ';
                    }
                    
                    echo '<a href="logOutUser.php" class="btn btn-outline-light">Log Out</a>';
                }
            ?>
        </section>
    </nav>
</header>