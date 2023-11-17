<?php
  class Connection{
    private $host = '';
    private $username = '';
    private $password = '';
    private $DB = '';

    function __construct(){
      $this->host = 'localhost';
      $this->username = 'root';
      $this->password = 'Suman@10';
      $this->DB = 'crud_db';
    }

    public function connect(){
      $conn = mysqli_connect($this->host, $this->username, $this->password, $this->DB);
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
      return $conn;
    }
  }


 ?>
