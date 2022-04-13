<?php
class Database {
    // инфа о БД
    private $host = "localhost";
    private $db_name = "indieduck";
    private $username = "user";
    private $password = 'pQXD6N!$YJr4pII6kn';
    public $conn;

    // получаем соединение с БД 
    public function getConnection(){
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>