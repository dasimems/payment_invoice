<?php
 require "functions.php";
 require "database.php";
 require "email.php";
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
    
     $total_quantity = array_reduce($invoice_quantity , function($carry , $item){
      $carry += $item;  
      return $carry;
   });
     $id = $database->generate_unique_id("invoice");
     
     $sql = "INSERT INTO `invoice`(`id`, `name`, `address` , `email`, `telephone`, `price`, `quantity`, `description` , `total_price`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?)";
     $values = [$id , $name , $address, $email , $telephone , json_encode($invoice_price) , 
     json_encode($invoice_quantity) ,  json_encode($invoice_description) , $total_price,
     "pending"];
     $eid = base64_encode($email);
      try {
         $database->insert($sql , $values);
        //send the email to the customer and redirect to the url
        $table_data = "";
        for($i = 0; $i < count($invoice_quantity) ; $i++){
         $no = $i + 1;
         $table_data .= "<tr><th>" . ($i + 1) . "</th><td>"  .
          $invoice_description[$i]. "</td><td>" . $invoice_price[$i] . 
          "</td><td>" . $invoice_quantity[$i] . "</td><td>" . 
          ($invoice_price[$i] * $invoice_quantity[$i]) . "</td></tr>";
        }
        $table_data .= '<tfoot><tr style="background: rgba(70,96,80, .3);">
            <th></th><td>Total</td><td></td><td>' . $total_quantity . '</td>
            <td>'  . $total_price . '</td></tr></tfoot>';
      $logo = base64_encode(file_get_contents(str_replace("\\" , '/' , dirname(__DIR__)) . "/assets/images/logo.jpg"));
      $temp = file_get_contents(str_replace("\\" , "/" , __DIR__) . "/emailtemplate.temp");
      $invoice_url = "http://" . $_SERVER["HTTP_HOST"] ."/invoice.php?id=" . $id;
      $url = "http://" . $_SERVER["HTTP_HOST"];
      $email_message = str_replace(["{{data.image}}" , "{{data.table}}" , "{{data.invoice_url}}"] , [$logo , $table_data , $invoice_url] , $temp);
      /* $mailer = new email;
       $mailer
       ->from("jagshood@gmail.com")
       ->to($email)
       ->subject("Invoice")
       ->html($email_message)
       ->send();*/
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