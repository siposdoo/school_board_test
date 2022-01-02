<?php 
class Database {
        private $host = "192.168.64.2";
        private $database_name = "school_board_db";
        private $username = "testuser";
        private $password = "#TestUser0909";

        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }  
    ?>