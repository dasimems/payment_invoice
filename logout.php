<?php
 session_start();
 session_unset();
 session_destroy();
 header("Status: 301");
 header("Location: login.php");
 exit;

?>