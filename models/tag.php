<?php

class Tag{

    private $conn; //строка подключения
    private $table_name = 'Tag'; //таблица

    public $TagID;
    public $Name;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getTags(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>