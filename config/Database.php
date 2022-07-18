<?php 
  include_once 'Init.php';
  
  class Database {
    // DB Params
    private $host = 'localhost';
    private $db_name = 'agpay_task';
    private $username = 'root';
    private $password = '';

    // private $host = 'ec2-44-206-197-71.compute-1.amazonaws.com';
    // private $db_name = 'd4cugeok8hlbbg';
    // private $username = 'zrlfkohgwmhbcz';
    // private $password = 'b51d86bd4e44c9005da37cda753b3e5b1f8f3e096f8abe5a0f90e4f7ba5f4622';

    private $conn;

    // DB Connect
    public function connect() {
      $this->conn = null;

      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo 'Connection Error: ' . $e->getMessage();
      }

      return $this->conn;
    }
  }