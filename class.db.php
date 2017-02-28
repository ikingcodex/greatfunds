<?php

session_start();
class DB {
    private $dbHost     = 'localhost';
    private $dbUsername = 'root';
    private $dbPassword = '';
    private $dbName     = 'greatfunds';
    public $db;

    /*
     * Connect to the database and return db connection
     */
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
                return $this->db;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }
}

require 'class.user.php';
require 'admin/class.admin.php';
$database = new DB();
$user = new USER($database->db);
$admin = new ADMIN($database->db);
