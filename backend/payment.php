<?php

use Symfony\Component\HttpClient\HttpClient;

 require_once "backend/database.php";
 require_once "vendor/autoload.php";
 require_once "backend/fetch_config.php";
 $invoice_id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : null;
$sql = "SELECT name , email , telephone , total_price from invoice where id = ?";
 $result = $database->scalar($sql , [$invoice_id]);
 $is_valid_id = !is_null($result);

  if($is_valid_id)
  {
        $price = $result["total_price"];
        $name = $result["name"];
        $email = $result["email"];
        $telephone = $result["telephone"];
        $currency = "NGN";
        $api_key = fetch_config::get_instance()->get('flutter_api_key');
        $tx_ref = base64_encode(random_bytes(10));
        $verify_url = "https://" . $_SERVER["HTTP_HOST"] . "/verify_payment.php";
         try {
     $http = HttpClient::create(["auth_bearer" => $api_key]);
     $res = $http->request("POST" , 'https://api.flutterwave.com/v3/payments' ,
         [ 'json' => [ 'tx_ref' => $tx_ref ,
                                'amount' => $price ,
                                'currency' => $currency ,
                                'redirect_url' => $verify_url ,
                                'customer' => [
                                       'email' => $email ,
                                       'phonenumber' => $telephone ,
                                       'name' => $name
                                             ]
                       ]
                       ]);
               
        $status = $res->getStatusCode();
        $data = $res->toArray();
        $status = $data["status"];
        if($status === "success"){
          $link = $data["data"]["link"];
          header("Status: 301");
          header("Location: $link");
          exit("redirecting you to the payment page");
           
        }    else 
        {
           die("oops! " . $data["message"]);
        }
            
        }
        catch (Exception $e){
         // echo $e->getMessage();
            echo "oops!!! something went wrong on our end";
                } 

  } 
   ?>
