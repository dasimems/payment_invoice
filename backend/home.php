<?php
 require "functions.php";
 require "database.php";

 session_start();
 check_login();

 $sql = "SELECT `id`, `description` , `email` , `quantity`, `total_price`, `status`, 
   `created_at` FROM `invoice` ";
 $result = $database->select($sql);
 $table = "";
 $no_result = (is_null($result) || empty($result)) ? true : false;
 $no = 0;
    
 foreach($result as $row){
       $invoice_id = $row["id"];
       $total_price = $row["total_price"];
   switch($row["status"]){
        case "pending" : $status = "unpaid"; $is_paid = false;
        break;
        case "successful" : $status = "paid"; $is_paid = true;
        break;
        default : $status = "unpaid"; $is_paid = false;
      }
   $status_th = $is_paid ? "<span class=\"paid\"> $status</span>" : 
    "<span class=\"unpaid\"> $status</span>";
    $quantity = json_decode($row["quantity"]);
    $total_quantity = array_reduce($quantity , function($carry , $current){
      $carry += $current;
      return $carry;
    });
  $time = strtotime($row["created_at"]);
  switch($date = date("d" , $time)){
        case ($date == "01" or $date == "1") : $date =  "1st";
        break;
        case ($date =="02" or $date == "2") : $date = "2nd";
        break;
        default: $date = $date . "th";
  }
  $id = $row["id"];
  $des = json_decode($row["description"]);
  $description = $des[0];
  $description = (strlen($description) >= 30) ? substr($description , 0 , 29) . '...' : $description;
  $des_count = (count($des) > 1) ? "<strong> +" . count($des) . "</strong>" : "";
  $email = $row["email"];
  $date = $date . " , " . date("M , Y" , $time);
   $table .= '<tr><th>' . ($no + 1) . "</th><td>$description" . $des_count. "</td>
 <td>$date</td><td>$email<td>" .
    $total_quantity . "</td><td>$total_price</td><td>" . $status_th .
   '</td><td><a href="invoice.php?id=' . $id . '" class="view-btn">View</a></td></tr>';
   $no++;
}
