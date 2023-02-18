<?php 
 namespace database;

use Exception;
use mysqli;

 /**
  * database connection class 
  *
  */

  class connection {
   /**
    * database port
    * 
    * @var int
    */

    private $port = 3306;

    /**
     * database domain
     * 
     * @var string
     */
    private $domain = 'localhost';

    /**
     * database username
     * 
     * @var string
     */

     private $username = '';

     /**
      * database password
      *
      */

      private $password = '';

      /**
       * database name
       * 
       */
     
      private  $dbname = null;

      /**
       * database connection
       * 
       */

       private $connection = null;

      /**
       * instance of the database connection class
       * 
       */
      private static $instance = null;

      /**
       * initialize the database connection
       * 
       */
   private function __construct(string $domain , string $username , string $password , string $dbname , int $port = 3306 )
   {

        $this->domain = $domain;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
        $this->connect();
   }

   /**
    * check if there is a database connection
    * 
    */
   private function connected()
   {
          if(!is_null($this->connection) && is_object($this->connection)){
                return true;
          } else {
                return false;
          }
   }

   /**
    * initialize a database connection 
    *
    */
   private function connect(){

        mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
        if($this->connected()){
                return;
        }
        try {
        $this->connection = new mysqli($this->domain , $this->username , $this->password , $this->dbname , $this->port);
        } 
        catch(Exception $e){
                throw new Exception($e->getMessage());
        }
   }

   public static function get_instance(string $domain , string $username , string $password , string $dbname , int $port = 3306)
   {
        if(!self::$instance){
                self::$instance = new self($domain , $username , $password ,  $dbname , $port = 3306);
        }
        return self::$instance;
   }
   /**
    * get the connection
    */

    public function get_connection(){
        return $this->connection;
    }

  }