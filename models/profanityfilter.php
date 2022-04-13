<?php

class ProfanityFilter{

    private $conn; //строка подключения
    private $table_name = 'ProfanityFilter'; //таблица

    public $ProfanityFilterID;
    public $Word;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getProfanityFilters(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>