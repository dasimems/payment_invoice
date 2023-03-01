<?php 
 require "./backend/payment.php";
 
 if(!$is_valid_id){
 ?>
 
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width"> -->
    <title>Not valid page page</title> <!-- TODO: update page title -->
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
    
    <script src="./assets/plugin/lottie_player/lottie-player.js"></script>
</head>
<body class="column align-center justify-center">

    <div class="background-image-container">
        <img src="./assets/images/logo.jpg" alt="jagshood" />
    </div>

    <div class="payment-response-container flex align-center">
        <div class="animation-element">
            <lottie-player class="lottie-animation" src="./assets/lottie/74118-error.json" background="transparent"  speed="1" autoplay></lottie-player>
        </div>
    
        <h4>Oops!!! seems this is not the page you are looking for</h4>

    </div>
 </body>
 </html>

 <?php
 }
  ?>