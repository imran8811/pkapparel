<?php
class Db {
    protected $db_conn;
//local
    public $db_name    =   "pkapparelstock";
    public $db_host    =   "localhost";
    public $db_user    =   "root";
    public $db_pass    =   "";
//live
//    public $db_name    =   "jeansfac_lahorijeans";
//    public $db_host    =   "localhost";
//    public $db_user    =   "jeansfac_lahori";
//    public $db_pass    =   "pak123istan";

    function connect_db(){
        try {
            $db_conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_name", "$this->db_user", "$this->db_pass");
            return $db_conn;
        } catch (PDOException $e){
            return $e->getMessage();
        }
    }
}


