<?php
 require "./backend/invoice.php";
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width"> -->
    <title>Payment Invoice for isaacseun63@gmail.com</title> <!-- TODO: update page title -->
    <script type="module">
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
 <?php
 if(is_null($id)){
    ?>
    <p>This invoice is not a valid invoice</p>
  <?php } else { ?>
    <div class="background-image-container">
        <img src="./assets/images/logo.jpg" alt="jagshood" />
    </div>

    <!-- This will be shown when the payment has been paid and someone redirects to the link-->
   <?php if($is_paid) { ?>
    <div class="paid-container">

        <img src="./assets/images/paid.png" alt="jagshood payment successful">

    </div> 
    <?php } ?>

    <div class="main-body">


        <div class="invoice-nav details">

            <p class="date"><?php echo $date; ?></p>

            <h3>Invoice - <?php echo "#$invoice_id";?> </h3>
            <?php if(!$is_paid){ ?>
            <a href="<?php echo $payment_processor_url ?>" class="button">Pay Now</a>
            <?php } else {?>
            <a href="javascript:void(0)" class="button">Already Paid</a>        
           <?php } ?>

        </div>

        <div class="invoice-details details">

            <div class="bussiness-logo">
                <img src="./assets/images/logo.jpg" alt="" />
            </div>

            <p>
                <b>Address : </b> <span>Uncle Wole Estate Ibulesoro, FUTA Northgate Akure. Ondo State</span>
            </p>

            <div class="flex company-details space-between">

                <div class="inner-details">
                    <p>
                        <b>Phone</b>
                    </p>

                    <p>
                        <a href="tel:+2348052410332">+(234) 805 241-0332</a>
                    </p>
                </div>

                <div class="inner-details">
                    <p>
                        <b>Email</b>
                    </p>

                    <p>
                        <a href="mailto: jagshood@gmail.com"> jagshood@gmail.com
</a>
                    </p>
                </div>

            </div>
            
        </div>

        <div class="customer-details details">

            <h4>Customer Details</h4>

            <div class="details-text">
                <p>
                    <b>Name : </b>
                </p>

                <p>
                <?php echo ucwords($customer_name) ?>
                </p>
            </div>

            <div class="flex company-details space-between">

                <div class="inner-details">
                    <p>
                        <b>Phone : </b>
                    </p>

                    <p>
                        <a href="tel:<?php echo $telephone ?>"> <?php echo $telephone ?></a>
                    </p>
                </div>

                <div class="inner-details">
                    <p>
                        <b>Email : </b>
                    </p>

                    <p>
                        <a href="mailto:<?php echo $customer_email ?>">     
                            <?php echo $customer_email ?>
                        </a>
                    </p>
                </div>

            </div>

            <div class="details-text">
                <p>
                    <b>Address : </b>
                </p>

                <p>
                    <?php echo $address ?>
                </p>
            </div>



        </div>

        <div class="product-details details">

            <h4>Invoice Details</h4>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Description</th>
                        <th>Price(&#8358;)</th>
                        <th>Quantity</th>
                        <th>Amount(&#8358;)</th>
                    </tr>
                </thead>

                <tbody>
                   <?php echo $table_body ?>
                    <tfoot>

                        <tr>
                            <th></th>
                            <td>Total</td>
                            <td></td>
                            <td><?php echo $total_quantity ?> </td>
                            <td><?php echo $total_price ?> </td>
                        </tr>

                    </tfoot>

                </tbody>
            </table>

            <div class="invoice-stats details-text flex space-between">

                <p>
                    <b>Status :</b>
                    <span>-<?php echo ucfirst($status); ?></span>
                </p>

                <p>
                    <b>Total: </b>
                    <span><?php echo "&#8358;$total_price"?></span>
                </p>

            </div>

        </div>

        

        <div class="invoice-action flex space-between details">

            <div class="mini-actions">
                <button class="transparent" data-action="print">

                    <i class="fa-solid fa-print"></i>

                </button>
            </div>
           <?php if(!$is_paid){ ?>
            <a href="<?php echo $payment_processor_url ?>" class="button">Proceed to payment</a>
            <?php } ?>

        </div>



    </div>
  
    <!-- Content -->
    <script src="./assets/js/index.js"></script> <!-- TODO: Update app entry point -->
    <script src="js/vendor/modernizr-{{MODERNIZR_VERSION}}.min.js"></script> <!-- TODO: Add Modernizr js -->
    <!-- <script src="/assets/js/xy-polyfill.js" nomodule></script> -->
    <!-- <script src="/assets/js/script.js" type="module"></script> -->
    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
        window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>
    <!-- <script src="https://www.google-analytics.com/analytics.js" async></script> -->
    <?php }; ?>
</body>
</html>