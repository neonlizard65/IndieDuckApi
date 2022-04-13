<?php

class ReportReason{

    private $conn; //строка подключения
    private $table_name = 'ReportReason'; //таблица

    public $ReportReasonID;
    public $ReasonName;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getReportReasons(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
}
?>