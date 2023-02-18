<?php
 require "email.php";

 try {
 $e = new email;
 $e->to('juliusarise1234@gmail.com');
 $e->from('julius.business12@gmail.com');
 $e->html("<p> hello it is me george just testing this</p>");
  $e->send();
 } catch(Exception $e){
        echo $e->getMessage();
 }