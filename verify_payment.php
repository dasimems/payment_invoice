<?php
require "./backend/functions.php";
require_once "./backend/database.php";
 require_once "./vendor/autoload.php";
 require_once "./backend/fetch_config.php";
 use Symfony\Component\HttpClient\HttpClient;

   $status = isset($_GET["status"]) ? htmlspecialchars($_GET["status"]) : null;
     $payment_id = isset($_GET["tx_ref"]) ? htmlspecialchars($_GET['tx_ref']) : null;
     $transaction_id = isset($_GET["transaction_id"]) ? htmlspecialchars($_GET["transaction_id"]) : 'null';
     $api_key = fetch_config::get_instance()->get('flutter_api_key');
      try {
  $http = HttpClient::create(["auth_bearer" => $api_key]);
  $res = $http->request("GET" , 'https://api.flutterwave.com/v3/transactions/' . $transaction_id .'/verify');
           
     $status_code = $res->getStatusCode();
     $data = $res->toArray();
     if($data["status"] === "success"){
     $transaction_data = $data["data"];
     $tx_ref = $transaction_data["tx_ref"];
     $transaction_successful = $transaction_data["status"] === "successful";
     $is_naira = $transaction_data["currency"] === "NGN";
     $overpaid = $transaction_data["charged_amount"] > $transaction_data["amount"];
     $under_paid = $transaction_data["charged_amount"] < $transaction_data["amount"];
     
     if($transaction_successful && $is_naira && !$under_paid){
        $database->update("update `invoice` set `status` = ? where payment_id = ? " , ["successful" , $tx_ref]);
        $invoice_id = $database->scalar("select id from invoice where payment_id = ?" , [$tx_ref])["id"];
        
        if($overpaid){
         refund($transaction_data["charged_amount"] - $transaction_data["amount"] , $transaction_id , $api_key , $invoice_id);
        } else {
         $url =  "http://" . $_SERVER["HTTP_HOST"] . "/invoice.php?id=" . $invoice_id;
         $link = '<a class="extra-link" href=" '.$url . '">View receipt</a>';
         $message = "Your payment have been made successfully";
         $success_message = str_replace(["{{data.link}}" , "{{data.message}}"] , [$link , $message], file_get_contents("paymentsuccess.html"));
         echo $success_message;
        }
      }  else {
         $message = "oops! payment unsuccessful, you can retry your payment by going to the invoice that was sent to your email";
         $failed_message = str_replace("{{data.message}}" , $message, file_get_contents("paymenterror.html"));
         echo $failed_message;
        }
     } else {
         $message = "oops " . $data["message"];
         $failed_message = str_replace("{{data.message}}" , $message, file_get_contents("paymenterror.html"));
         echo $failed_message;
     }
     
           
    }
       catch(Exception $e){
             if(strpos($e->getMessage() , "400") > 0){
                $url =  "http://" . $_SERVER["HTTP_HOST"] . "/payment.php";
                $message = "oops invalid transaction id";
                $failed_message = str_replace(["{{data.link}}" , "{{data.message}}"] , [$link , $message], file_get_contents("paymenterror.html"));
                echo $failed_message;
             } else {
            echo $e->getMessage();
             }
          }

          function refund($amount , $transaction_id , $api_key , $invoice_id)
          {
                try {
                        $http = HttpClient::create(["auth_bearer" => $api_key]);
                        $res = $http->request("POST" , 'https://api.flutterwave.com/v3/transactions/' . $transaction_id .'/refund' , [
                                "body" => ["amount" => $amount]
                        ]);
                                 
                           $status_code = $res->getStatusCode();
                           $data = $res->toArray();
                           if($data["status"] === "success"){
                           $transaction_data = $data["data"];
                            $message = ($transaction_data["status"] === "completed") ? "payment succesfull and your overpaid $amount has being refunded successfully" : "Payment successful but your overpaid $amount could not be refunded contact support";
                            $url =  "http://" . $_SERVER["HTTP_HOST"] . "/invoice.php?id=" . $invoice_id;
                            $link = '<a class="extra-link" href=" '.$url . '">View receipt</a>';
                            $success_message = str_replace(["{{data.link}}" , "{{data.message}}"] , [$link , $message], file_get_contents("paymentsuccess.html"));
                            echo $success_message;
                           } 
                          
                                 
                          }
                             catch(Exception $e){
                            $message = "Your payment is successful but something went wrong so your overpaid N$amount could not be refunded, contact support at jagshood@gmail.com";
                            $url =  "http://" . $_SERVER["HTTP_HOST"] . "/invoice.php?id=" . $invoice_id;
                            $link = '<a class="extra-link" href=" '.$url . '">View receipt</a>';
                            $success_message = str_replace(["{{data.link}}" , "{{data.message}}"] , [$link , $message], file_get_contents("paymentsuccess.html"));
                            echo $success_message;
                                }
          }
 
?>