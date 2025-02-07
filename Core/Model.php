<?php

// namespace Core;

class Model {
  public $db_name;
  public $db_host;
  public $db_user;
  public $db_password;
  public $pdo;

  public function __construct() {
    $this->db_host = "localhost";
    $this->db_name = "pkappar2_wholesale_2166718";
    $this->db_user = "root";
    $this->db_password = "";
    $dsn = "mysql:host=$this->db_host;dbname=$this->db_name";
    $this->pdo = new PDO($dsn, $this->db_user, $this->db_password);
  }
}

?>
