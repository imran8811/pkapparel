<?php

namespace Core;
use \PDO;
use PDOException;

class DbModel {
  protected $db_name;
  protected $db_host;
  protected $db_user;
  protected $db_password;

  public function __construct(){
    $this->db_host = getenv('DB_HOST');
    $this->db_name = getenv('DB_NAME');
    $this->db_user = getenv('DB_USER');
    $this->db_password = getenv('DB_PASSWORD');
    $dsn = "mysql:host=$this->db_host;dbname=$this->db_name";
    try {
      return new PDO($dsn, $this->db_name, $this->db_password);
    }catch(PDOException $e){
      return $e->getMessage();
    }
  }
}

?>
