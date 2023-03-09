<?php
 require "./backend/home.php";

?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width"> -->
    <title>Invoice List</title> <!-- TODO: update page title -->
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
    <!-- <link rel="manifest" href="site.webmanifest"> TODO: update web app manifest file -->
    <meta name="theme-color" content="#FF00FF"> <!-- TODO: update meta theme color -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">  <!-- TODO: Update styles -->
    <link rel="stylesheet" href="./assets/css/index.css">  <!-- TODO: Update styles -->
    <link rel="stylesheet" href="./assets/css/index.css" media="print">
    
    <script src="./assets/plugin/lottie_player/lottie-player.js"></script>
</head>
<body class="padding-0">

    <div class="background-image-container">
        
        <img src="./assets/images/logo.jpg" alt="jagshood" />
        
    </div>
    <div class="main-body invoice full-width">


        <div class="flex nav fixed top-0 left-0 full-width space-between align-center">

            <img src="./assets/images/logo.jpg" class="nav-logo" alt="jagshood logo" />

            <a class="button" href="./logout.php">Logout</a>

        </div>


        <div class="main-content">
            <div class="flex space-between wrap align-center">
    
                <a href="./addinvoice.php" class="button add-invoice-button">Add Invoice &nbsp; <i class="fa-solid fa-plus"></i></a>

                <!--form action="" class="flex search-form" method="get">

                    <input type="search" placeholder="Your keyword" class="search-box" />

                    <button type="submit" class="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>

                </form-->


    
            </div>

            <!-- Show this if there's no invoice details -->
          <?php if($no_result){ ?>
            <div class="empty-invoice flex align-center column justify-center">

                <lottie-player class="empty-invoice-animation" src="./assets/lottie/93134-not-found.json" background="transparent"  speed="1" autoplay></lottie-player>

                <p class="opacity-75">No invoice available at the present moment</p>

            </div> 
            <?php } else { ?>
            <table class="invoice-table logged-in-invoice-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Description</th>
                         <th>Date</th>
                         <th>Email</th>
                        <th>Total Quantity</th>
                        <th>Total price(&#8358;)</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody><?php echo $table ?> </tbody>
            </table>
             <?php }; ?>
        </div>



    </div>

    <!-- Content -->
    <script src="./assets/js/index.js"></script> <!-- TODO: Update app entry point -->
    <!-- <script src="js/vendor/modernizr-{{MODERNIZR_VERSION}}.min.js"></script> TODO: Add Modernizr js -->
    <!-- <script src="/assets/js/xy-polyfill.js" nomodule></script>
    <script src="/assets/js/script.js" type="module"></script> -->
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
        window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>
    <!-- <script src="http://www.google-analytics.com/analytics.js" async></script> -->
</body>
</html>
