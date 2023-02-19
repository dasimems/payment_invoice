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
    <title>Generate Payment Invoice</title> <!-- TODO: update page title -->
    <script type="module" nonce="<?php echo $nonce ?>">
            document.documentElement.classList.remove('no-js');
            document.documentElement.classList.add('js');
    </script>
    <meta name="description" content="Payment Invoice"> <!-- TODO: update meta description -->
    <meta property="og:title" content="Home - Page">  <!-- TODO: update og:title -->
    <meta property="og:url" content="https://www.example.com/page"> <!-- TODO: update og:url -->
    <meta property="og:description" content="OG Page Description">  <!-- TODO: update og:description -->
    <meta property="og:image" content="./assets/images/logo_cropped.png">  <!-- TODO: og:image -->
    <meta property="og:image:alt" content="OG Image Description"> <!-- TODO: update og:image:alt --> 
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="large-image-twitter.jpg"> <!-- TODO: update twitter:cared -->
    <!-- <link rel="canonical" href="https://www.example.com/page"> TODO: update canonical link -->
    <link rel="icon" href="./assets/images/favicon.ico">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="./assets/images/apple-touch-icon.png">
    <link rel="manifest" href="site.webmanifest"> <!-- TODO: update web app manifest file -->
    <meta name="theme-color" content="#FF00FF"> <!-- TODO: update meta theme color -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">  <!-- TODO: Update styles -->
    <link rel="stylesheet" href="./assets/css/index.css">  <!-- TODO: Update styles -->
    <link rel="stylesheet" href="./assets/css/index.css" media="print">
</head>
<body>

    <div class="background-image-container">
        <img src="./assets/images/logo.jpg" alt="jagshood" />
    </div>

    <div class="main-body">

        <div class="invoice-header details flex space-between align-center">

            <p>20th Feb 2023</p>

            <h3>Generate Invoice</h3>

            <a href="" class="button">Logout</a>

        </div>

        <div class="invoice-form-container details">
            <form action="backend/addinvoice.php" method="post" class="invoice-form flex space-between wrap">

                <h4 class="form-inner-title">Customer Details</h4>

                <div class="form-content full-width">
                    <label for="name" data-name="name">Customer's Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Customer's name" data-name="name" data-name-err="Please Input a valid name" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="Please input a valid name" data-regex="^[a-zA-Z '.-]*$" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="name">
                        this is an error
                    </p>
                </div>

                <div class="form-content half-width">
                    
                    <label for="email" data-name="email">Customer's Email</label>
                    <input type="email" name="email" id="email" placeholder="Your email" data-name="email" data-name-err="Please Input a valid email address" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="Please input a valid email address" data-regex="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="email">
                        this is an error
                    </p>
                </div>

                <div class="form-content half-width">
                    
                    <label for="mobile-number" data-name="mobile-number">Customer's Phone Number</label>
                    <input type="tel" name="mobile-number" id="mobile-number" placeholder="Customer's mobile number" data-name="mobile-number" data-name-err="Please Input a valid mobile number with country code" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="Please input a valid  mobile number with country code" data-regex="^\+[1-9]{1}[0-9]{10,14}$" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="mobile-number">
                        this is an error
                    </p>
                </div>

                <input type="hidden" name="invoice-details-count"  class="invoice-details-count" value="0">
                <input type="hidden" name="csrf-token" value="<?php echo $csrf_token ?>">
                <h4 class="form-inner-title full-width">Invoice Details - #1</h4>


                <div class="form-content half-width">
                    
                    <label for="invoice-price-0" data-name="invoice-price-0">Price</label>
                    <input type="number" name="invoice-price" id="invoice-price-0" placeholder="Price" data-name="invoice-price-0" data-name-err="" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="" data-regex="" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="invoice-price-0">
                        this is an error
                    </p>
                </div>

                <div class="form-content half-width">
                    
                    <label for="invoice-quantity-0" data-name="invoice-quantity-0">Quantity</label>
                    <input type="number" name="invoice-quantity" id="invoice-quantity-0" placeholder="Quantity" data-name="invoice-quantity-0" data-name-err="" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="" data-regex="" data-min="" data-max="" data-required="true" >
                    <p class="form-err" data-name="invoice-quantity-0">
                        this is an error
                    </p>
                </div>

                <div class="form-content full-width">
                    
                    <label for="invoice-description-0" data-name="invoice-description-0">Description</label>
                    
                    <textarea type="number" name="invoice-description" id="invoice-description-0" placeholder="Description..." data-name="invoice-description-0" data-name-err="" data-required-err="This field is required" data-min-err="" data-max-err="" data-regex-err="" data-regex="" data-min="" data-max="100" data-required="true" ></textarea>
                    <p class="form-err" data-name="invoice-description-0">
                        this is an error
                    </p>
                </div>


                <div class="form-content action-btn-container row full-width flex justify-end">
                    <button type="button" class="action-btn">

                        <span class="text">

                            Add new details 
                        </span>

                        <span class="icon">
                            
                            <i class="fa-solid fa-plus"></i>
                        </span>
                    </button>
                </div>

                <div class="form-content form-action full-width">
                    <button type="submit" class="full-width">Submit</button>
                </div>
            </form>
        </div>



    </div>

    <!-- Content -->
    <script src="./assets/js/index.js" nonce="<?php echo $nonce ?>"></script> <!-- TODO: Update app entry point -->
    <script src="./assets/js/addinvoice.js" nonce="<?php echo $nonce ?>"></script> <!-- TODO: Update app entry point -->
    <script src="js/vendor/modernizr-{{MODERNIZR_VERSION}}.min.js" nonce="<?php echo $nonce ?>"></script> <!-- TODO: Add Modernizr js -->
    <!-- <script src="/assets/js/xy-polyfill.js" nomodule nonce="<?php echo $nonce ?>"></script> -->
    <!-- <script src="/assets/js/script.js" type="module" nonce="<?php echo $nonce ?>"></script> -->
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script nonce="<?php echo $nonce ?>">
         window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>
    <!--<script src="https://www.google-analytics.com/analytics.js" async nonce="<?php echo $nonce ?>"></script> -->
</body>
</html>