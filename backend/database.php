<?php

//this file bootstrap the database component

use database\manager;

 require "database/manager.php";
  require "fetch_config.php";
 
  $config = fetch_config::get_instance()->get("database");
  $password = $config["password"];
  $username = $config["username"];
  $host = $config["host"];
  $database = $config["database"];
  $database = new manager($host , $username , $password , $database);
 // $database->disable_prepared_statement();