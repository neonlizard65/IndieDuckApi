<?php

class PrivacyType{

    private $conn; //строка подключения
    private $table_name = 'PrivacyType'; //таблица

    public $PrivacyTypeID;
    public $Name;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getPrivacyTypes(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>