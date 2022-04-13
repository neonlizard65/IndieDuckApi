<?php

class TicketReason{

    private $conn; //строка подключения
    private $table_name = 'TicketReason'; //таблица

    public $TicketReasonID;
    public $Name;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getTicketReasons(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>