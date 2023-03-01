<?php
 require "functions.php";
 require "database.php";
 session_start();

 if(validate_csrf_token()){
 
    $name = htmlspecialchars($_POST["name"]);
    $address = htmlspecialchars($_POST["address"]);
    $email = htmlspecialchars($_POST["email"]);
    $telephone = htmlspecialchars($_POST["mobile-number"]);
    $invoice_price = array_html_special_chars($_POST["invoice-price"]);
    $invoice_quantity = array_html_special_chars($_POST["invoice-quantity"]);
    $invoice_description = array_html_special_chars($_POST["invoice-description"]);
    $iteration = 0;
     $total_price = array_reduce($invoice_price , function($carry , $item){
        $carry += $item * ($GLOBALS["invoice_quantity"][$GLOBALS["iteration"]]);
        $GLOBALS["iteration"]++;
        return $carry;
     });
     $id = $database->generate_unique_id("invoice");
     
     $sql = "INSERT INTO `invoice`(`id`, `name`, `address` , `email`, `telephone`, `price`, `quantity`, `description` , `total_price`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?)";
     $values = [$id , $name , $address, $email , $telephone , json_encode($invoice_price) , 
     json_encode($invoice_quantity) ,  json_encode($invoice_description) , $total_price,
     "pending"];
     $eid = base64_encode($email);
     $url = "http://" . $_SERVER["HTTP_HOST"] . "/invoicecreated.php?id=$id&eid=$eid";
     try {
         $database->insert($sql , $values);
        //send the email to the customer and redirect to the url
        header("Status: 301");
       header("Location: $url");
        exit;
     } catch(Exception $e){
        echo $e->getMessage();
     }
  } 
 else {
        die("Oops! something went wrong seems like the form is manipulated, please kindly go back to the form page");
 }