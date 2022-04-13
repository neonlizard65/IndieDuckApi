<?php

class Status{

    private $conn; //строка подключения
    private $table_name = 'Status'; //таблица

    public $StatusID;
    public $StatusName;
    public $StatusIcon;
    public $StatusColor;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getStatuses(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>