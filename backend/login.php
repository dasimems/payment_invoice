<?php
  require "functions.php";

  session_start();
  if(validate_csrf_token()){
  $error = '<p style=" font-size: 0.7rem; color: var(--danger) !important; margin: 4px">%s</p>';

  $username = isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : null;
  $password = isset($_POST["password"]) ? htmlspecialchars($_POST["password"]) : null;
   $url = isset($_GET["redir"]) ? htmlspecialchars($_GET["redir"]) : null;
   $url = !is_null($url) ? "..". urldecode($url) : "../index.php";
   $stored_user_name = file_get_contents(".username");
   $user_name_decrypt = decrypt($stored_user_name);
   $stored_psw = file_get_contents(".password");
   $decrypt_psw = decrypt($stored_psw);
    $correct_name = $user_name_decrypt === $username;
   $correct_psw = password_verify($password , $decrypt_psw);
   if($correct_name && $correct_psw)
   {
        $session_id = tokenizer(random_bytes(10));
        $_SESSION["login_session"] = $session_id;
        header("Status: 301 ");
        header("Location: $url");
        exit;
   } 
   else 
   {
        $psw_err = !$correct_psw ? sprintf($error , "incorrect password") : null;
        $usern_err = !$correct_name ? sprintf($error , "incorrect username") : null;
        $_SESSION["psw_err"] = $psw_err;
        $_SESSION["usern_err"] = $usern_err;
        header("Status: 301");
        header("Location: ../login.php");
        exit;
   }
     
  
  } 
  else {
        exit("<p>Oops! something gone wrong, seems like the form has expired or this is a potential csrf attack,  you can simply go back to the login page</p>");
  }
 
 ?>