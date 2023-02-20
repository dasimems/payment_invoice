<?php

 function generate_csrf_token(){
   $token =  base64_encode(md5(random_bytes(20)));
   $_SESSION["csrf_token"] = $token;
   return $token;
 }

 function validate_csrf_token(){
        $token = isset($_POST["csrf-token"]) ? $_POST["csrf-token"] : null;
        $stored_token = isset($_SESSION["csrf_token"]) ? $_SESSION["csrf_token"] : null;
        session_unset();
        unset($_POST["csrf-token"]);
        return $token === $stored_token;
        
 }

 function array_html_special_chars($array){
  return array_map(
    function($item){
      if(is_int($item)){ return $item; }
     return htmlspecialchars($item);
    } , $array
  );
 }
