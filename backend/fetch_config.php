<?php
 
 class fetch_config {

        private  $config = null;

        private static $instance = null;

        private function __construct()
        { 
                $this->init();
        }

        /**
         * use to get the instance of the class
         * 
         */
        public static function get_instance()
        {
           if(!is_null(self::$instance)) return self::$instance;
           self::$instance = new self;
           return self::$instance;
        }

        /**
         * for setting a configuartion variable
         * 
         */
        public static function set(string $attr , $value)
        {
            $config[$attr] = $value;
        }

        /**
         * fetch the config.php file and store
         * it in the $config variable
         * 
         */
        protected function init()
        {
           if(is_null($this->config) && !is_array($this->config)){
                $this->config = require("config.php");
               
           }
        }

        /**
         * for getting a configuration
         * f
         */
        public function get($attr){
            return  isset($this->config[$attr]) ? $this->config[$attr] : null;
        }

        /**
         * checks if the supplied key exists in
         * the configuration
         * 
         */
        public function has($key){
                return isset($this->config[$key]);
        }

        /**
         *  return all of the configuration
         * 
         */
        public function get_all(){
                return $this->config;
        }

 }