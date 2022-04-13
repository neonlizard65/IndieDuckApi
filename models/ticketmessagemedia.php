<?php

class TicketMessageMedia{

     private $conn; //строка подключения
    private $table_name = 'TicketMessageMedia'; //таблица

    public $TicketMessageMediaID;
    public $TicketMessageId;
    public $Media;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getMessagesByTicket(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE TicketMessageId =:TicketMessageId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TicketMessageId", $this->TicketMessageId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    TicketMessageId=:TicketMessageId,
                    Media=:Media";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TicketMessageId=htmlspecialchars(strip_tags($this->TicketMessageId));
        $this->Media=htmlspecialchars(strip_tags($this->Media));

        // привязка значений 
        $stmt->bindParam(":TicketMessageId", $this->TicketMessageId);
        $stmt->bindParam(":Media", $this->Media);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //обновление групп
    function update(){
        // запрос для вставки (создания) записей 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    TicketMessageId=:TicketMessageId,
                    Media=:Media
                WHERE
                    TicketMessageMediaID = :TicketMessageMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TicketMessageMediaID=htmlspecialchars(strip_tags($this->TicketMessageMediaID));
        $this->TicketMessageId=htmlspecialchars(strip_tags($this->TicketMessageId));
        $this->Media=htmlspecialchars(strip_tags($this->Media));

        // привязка значений 
        $stmt->bindParam(":TicketMessageMediaID", $this->TicketMessageMediaID);
        $stmt->bindParam(":TicketMessageId", $this->TicketMessageId);
        $stmt->bindParam(":Media", $this->Media);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE TicketMessageMediaID =:TicketMessageMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->TicketMessageMediaID=htmlspecialchars(strip_tags($this->TicketMessageMediaID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":TicketMessageMediaID", $this->TicketMessageMediaID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>