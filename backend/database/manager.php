<?php
  namespace database;

  //include the database connection class;
   include "connection.php";

   use database\connection;
   use Exception;
use mysqli;

   /**
    * database connection manager 
    *
    */
   class manager {
        
    /**
     * hold the database connection instance
     * 
     * @var object
     */
    private  $connection = null;

    /**
     * the last error
     * 
     * @var false|string
     */

     private $last_error = false;

     /**
      * set if prepared statement should be used for the
      * current database transaction 
      *
      */

      private $is_prepared = true;

     /**
      * prepared statement
      *
      */

      private $stmt = null;

      /**
       * the result of the transaction
       * 
       */
      private $result = null;

     public function __construct($host , $username , $password , $database)
     {

   try {
     $this->connection = connection::get_instance($host , $username , $password , $database)->get_connection();

   } catch(Exception $e){
        echo $e->getMessage();
      } 
      }

      /**
       * return the database last error
       * 
       */
   private function get_db_last_error()
   {
      return $this->connection->error;
      
   }
   
   /**
    * rollback the database transaction 
    *
    */
   public function rollback(){
    $this->connection->rollback();
    return $this;
   }
  
   /**
    *  commit the database transaction
    *
    */
    public function commit(){
      $this->connection->commit();
      return $this;
    }

    /**
     * disable the use of prepared statement
     * 
     */

     public function disable_prepared_statement(){
      $this->is_prepared = false;
      return $this;
     }

    /**
     * enable the use of prepared statement
     * 
     */

    public function enable_prepared_statement(){
      $this->is_prepared = true;
      return $this;
     }
   
     /**
      * prepare a statement
      *
      */

     private function prepare($sql){
      $this->stmt = $this->connection->prepare($sql);
      return $this;
     }

     /**
      * 
      * binds a prepared statement
      *
      */

     private function bind($params)
     {
        if(is_array($params) && (count($params) < 1)){
          throw new Exception('can not bind empty params');
        }
        $variables = str_repeat('s' , count($params));
        $this->stmt->bind_param($variables , ...$params);
     }

     /**
      *  executes a prepared statement
      *
      */

      private function exec_prepared_statement()
      {
            $this->stmt->execute();
            $this->result = $this->stmt->get_result();
      }

     /**
      * runs a sql query against the database without using 
      * prepared statement
      *
      * @param string $sql
      */
     private function query($sql)
     {
           $this->result = $this->connection->query($sql);
     }

     /**
      * get the whole result as an associative array
      * 
      */
      private function fetch_all_as_assoc_array()
      {
          return $this->result->fetch_all(MYSQLI_ASSOC);
      }
      /**
       * get the whole result as a number array
       * 
       */
      private function fetch_all_as_num_array()
      {
        return $this->result->fecth_all(MYSQLI_NUM);
      }

      /**
       * fetches a single row as an associative array
       * 
       */

       private function fetch_one()
       {
        return $this->result->fetch_assoc();
       }
       /**
        * get the number of rows
        *
        */

        private function get_number_of_result()
        {
          return $this->result->num_rows;
        }

        /**
         * close both the prepared statement and
         * database connection
         */
        public function close()
        {
          if(!is_null($this->stmt)){
          $this->stmt->close();
          }
          $this->connection->close();
        }
        /**
         * execute an sql query
         * 
         */

         private function execute_query(string $sql , $params)
         {
            if(!$this->is_prepared)
            {
              $this->query($sql);
            }
            else
             {
               $this->prepare($sql);
               if(!is_null($params)){
               if(!is_array($params)){ $params = [$params]; }
                 $this->bind($params);
               }
               $this->exec_prepared_statement();
            }
         }

         /**
          * execute a select statement against the database
          * and return all the rows
          * @param string $sql
          * @param string|array|int $param
          * @param bool $is_assoc specify if the result should be fethed as
          * an associative array, default is true
          * @return array returns all the rows as an array
          */

          public function select(string $sql , $params = null , bool $is_assoc = true)
          {
             $this->execute_query($sql , $params);
             if($is_assoc){
             $result = $this->fetch_all_as_assoc_array(); 
             } else {
              $result = $this->fetch_all_as_num_array();
             }
             return $result;
          }
        
          /**
          * execute a select statement against the database and
          * return a single row as an associative array
          *
          * @param string $sql
          * @param string|array|int $param
          * an associative array, default is true
          */

          public function scalar(string $sql , $params = null)
          {
               $this->execute_query($sql , $params);
               $result = $this->fetch_one(); 
                return $result;
          }

          /**
          * execute an update statement against the database
          *
          * @param string $sql
          * @param string|array|int $param
          */

          public function update(string $sql , $params = null)
          {
             $this->execute_query($sql , $params);
             
          }
          /**
          * execute a delete statement against the database
          *
          * @param string $sql
          * @param string|array|int $param
          */

          public function delete(string $sql , $params = null)
          {
             $this->execute_query($sql , $params);
            
          }

          /**
           * get the last error
           * 
           */

           public function get_last_error()
           {
             return $this->get_db_last_error();
           }

            /**
             * 
             * generates a unique id for the specified table
             * @param string $table_name   the name of the table 
             * you want to generate an id for
             */
   public function generate_unique_id($table_name){
    try {
            if(!empty($table_name)){
    $id =  str_shuffle(123456789123456);
    $final_id = substr($id, 0, strlen($id));
    while($this->check_id($id,$table_name) > 0){
          $final_id = substr($id, 0, strlen($id));
    }
          return $final_id;
         } 
        } catch(Exception $e){
                throw New Exception($e->getMessage());
        }
      }
      private function check_id($id,$table_name){
        try {
       return $this->scalar("select count(id) as result from $table_name where id = ? " , $id)["result"];
        } catch(Exception $e){
                throw New Exception($e->getMessage());
        }
  }

 }
   

 
 ?>