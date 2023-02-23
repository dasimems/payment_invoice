<?php
 require "database.php";
 $id = (isset($_GET["id"]) && !empty($_GET["id"])) ? htmlspecialchars($_GET["id"]) : null;

 $sql = "SELECT `id`, `name`, `address`, `email`,
  `telephone`, `price`, `quantity`, `description`,
   `total_price`, `status`, 
   `created_at` FROM `invoice` WHERE id=?";
 $result = $database->scalar($sql , [$id]);
 //check if the invoice sql return null if true, it means a wrong
 // id was supplied meaning the query parameter was tempered with, hence 
 // the invoice is not a valid invoice
 if(is_null($result)){
        $id = null;
        return;
 }
 $invoice_id = $result["id"];
 $total_price = $result["total_price"];
 $customer_name = $result["name"];
 $customer_email = $result["email"];
 $telephone = $result["telephone"];
 $address = $result["address"];
 switch($result["status"]){
       case "pending" : $status = "unpaid"; $is_paid = false;
        break;
        case "successful" : $status = "paid"; $is_paid = true;
        break;
        default : $status = "unpaid"; $is_paid = false;
   }
  $price = json_decode($result["price"]);
  $description = json_decode($result["description"]);
  $quantity = json_decode($result["quantity"]);
  $time = strtotime($result["created_at"]);
  switch($date = date("d" , $time)){
        case ($date == "01" or $date == "1") : $date =  "1st";
        break;
        case ($date =="02" or $date == "2") : $date = "2nd";
        break;
        default: $date = $date . "th";
  }
  $date = $date . " " . date("M  Y" , );
  $table_body = "";
  $total_quantity = 0;
  for ($i = 0; $i < count($price); $i++){
        $total_quantity += $quantity[$i];
     $table_body .= "<tr><th>". ($i + 1) . "</th><td>". $description[$i] . 
     "</td><td>" . $price[$i] . "</td><td>" . $quantity[$i] . 
     "</td><td>". ($price[$i] * $quantity[$i]) . "</td></tr>";
  }
  $payment_processor_url = "./payment.php?id=" . $id;
 