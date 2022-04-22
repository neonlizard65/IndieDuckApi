<?php

class Country{

    private $conn; //строка подключения
    private $table_name = 'Country'; //таблица

    public $CountryID;
    public $CountryName;
    public $CountryCode;
    public $CountryFlag;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getCountries(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>