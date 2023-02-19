<?php
 require "functions.php";
 session_start();

 if(validate_csrf_token()){
print_r($_POST["csrf-token"]);
 } else {
        die("Oops! something went wrong seems like the form is manipulated, please kindly go back to the form page");
 }