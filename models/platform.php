<?php

class Platform{

    private $conn; //строка подключения
    private $table_name = 'Platform'; //таблица

    public $PlatformID;
    public $Name;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getPlatforms(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>