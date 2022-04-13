<?php

class AssistantTicket{

    private $conn; //строка подключения
    private $table_name = 'AssistantTicket'; //таблица

    public $AssistantTicketID;
    public $TicketId;
    public $AssistantId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getAllAssistantsByTickets(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE TicketId =:TicketId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TicketId", $this->TicketId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getAllTicketsByAssistants(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE AssistantId =:AssistantId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AssistantId", $this->AssistantId);
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
                    TicketId=:TicketId,
                    AssistantId=:AssistantId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TicketId=htmlspecialchars(strip_tags($this->TicketId));
        $this->AssistantId=htmlspecialchars(strip_tags($this->AssistantId));

        // привязка значений 
        $stmt->bindParam(":TicketId", $this->TicketId);
        $stmt->bindParam(":AssistantId", $this->AssistantId);
        
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
                    TicketId=:TicketId,
                    AssistantId=:AssistantId
                WHERE 
                    AssistantTicketID = :AssistantTicketID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AssistantTicketID=htmlspecialchars(strip_tags($this->AssistantTicketID));
        $this->TicketId=htmlspecialchars(strip_tags($this->TicketId));
        $this->AssistantId=htmlspecialchars(strip_tags($this->AssistantId));

        // привязка значений 
        $stmt->bindParam(":AssistantTicketID", $this->AssistantTicketID);
        $stmt->bindParam(":TicketId", $this->TicketId);
        $stmt->bindParam(":AssistantId", $this->AssistantId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE AssistantTicketID =:AssistantTicketID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->AssistantTicketID=htmlspecialchars(strip_tags($this->AssistantTicketID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":AssistantTicketID", $this->AssistantTicketID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>