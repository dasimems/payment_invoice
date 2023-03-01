<?php
 require "backend/functions.php";
 session_start();
 $csrf_token = generate_csrf_token();
 $nonce = base64_encode(random_bytes(14));

 header("Content-Security-Policy: script-src 'nonce-$nonce'");

 ?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width"> -->
    <title>Login</title> <!-- TODO: update page title -->
    <script type="module">
            document.documentElement.classList.remove('no-js');
            document.documentElement.classList.add('js');
    </script>
    <meta name="description" content="Payment Invoice"> <!-- TODO: update meta description -->
    <meta property="og:title" content="Home - Page">  <!-- TODO: update og:title -->
    <meta property="og:url" content="http://www.example.com/page"> <!-- TODO: update og:url -->
    <meta property="og:description" content="OG Page Description">  <!-- TODO: update og:description -->
    <meta property="og:image" content="./assets/images/logo_cropped.png">  <!-- TODO: og:image -->
    <meta property="og:image:alt" content="OG Image Description"> <!-- TODO: update og:image:alt --> 
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="large-image-twitter.jpg"> <!-- TODO: update twitter:cared -->
    <!-- <link rel="canonical" href="http://www.example.com/page"> TODO: update canonical link -->
    <link rel="icon" href="./assets/images/favicon.ico">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="./assets/images/apple-touch-icon.png">
    <link rel="manifest" href="site.webmanifest"> <!-- TODO: update web app manifest file -->
    <meta name="theme-color" content="#FF00FF"> <!-- TODO: update meta theme color -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">  <!-- TODO: Update styles -->
    <link rel="stylesheet" href="./assets/css/index.css">  <!-- TODO: Update styles -->
    <link rel="stylesheet" href="./assets/css/index.css" media="print">
</head>
<body>

    <div class="background-image-container">
        <img src="./assets/images/logo.jpg" alt="jagshood" />
    </div>

    <div class="main-body login-body">

        <div class="details flex justify-center">
            <h4>Login</h4>
        </div>

        
        <div class="details">
            <form action="./backend/login.php" method="post" class="flex space-between wrap">
                <input type="hidden" name="csrf-token" value="<?php echo $csrf_token ?>">
                <div class="form-content full-width">
                    <label for="username" data-name="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Your username">
                    <p class="form-err" data-name="username" >
                        this is an error
                    </p>
                    <?php
                    echo isset($_SESSION["usern_err"]) ? $_SESSION["usern_err"] : null;
                    $_SESSION["usern_err"] = null;
                    ?>
                </div>

                <div class="form-content full-width">
                    <label for="password" data-name="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Your password">
                    <p class="form-err" data-name="password">
                        this is an error 
                    </p>
                    <?php
                    echo isset($_SESSION["psw_err"]) ? $_SESSION["psw_err"] : null;
                    $_SESSION["psw_err"] = null;
                    ?>
                </div>

                <div class="form-content action-btn-container row full-width flex justify-end">
                    <button type="submit">
                        Login
                    </button>
                </div>
    
            </form>
            
        </div>


    </div>

    <!-- Content -->
    <!--<script src="./assets/js/index.js" nonce="<?php echo $nonce; ?>"></script> --><!-- TODO: Update app entry point -->
    <script src="./js/vendor/modernizr-{{MODERNIZR_VERSION}}.min.js" nonce="<?php echo $nonce ?>"></script> <!-- TODO: Add Modernizr js -->
    <!-- <script src="/assets/js/xy-polyfill.js" nomodule></script> -->
    <!-- <script src="/assets/js/script.js" type="module"></script> -->
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <!--<script>
        window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>-->
    <!-- <script src="http://www.google-analytics.com/analytics.js" async></script> -->
</body>
</html>