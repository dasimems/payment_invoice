<?php

use Symfony\Component\HttpClient\HttpClient;

 require "vendor/autoload.php";

 try {
 $http = HttpClient::create(["auth_bearer" => 
 'FLWSECK_TEST-543a9af52d7b30312df278734fc86f7b-X'
]);
 
$res = $http->request("POST" , 'https://api.flutterwave.com/v3/payments' ,
[
        'json' => [
                  'tx_ref' => '48rufhgcsk' ,
                 'amount' => '200' ,
                 'currency' => "NGN" ,
                 'redirect_url' => 'http://msite.com/verify_payment.php' ,
                 'customer' => [
                        'email' => 'juliusarise1234@gmail.com' ,
                        'phonenumber' => '09067950069' ,
                        'name' => 'julius George'
                 ]
        ]
        ]);

       $status = $res->getStatusCode();
       echo $res->getContent();
}
catch (Exception $e){
        echo $e->getMessage();
}