<?php

class TicketMessage{

    private $conn; //строка подключения
    private $table_name = 'TicketMessage'; //таблица

    public $TicketMessageID;
    public $TicketId;
    public $AssistantId;
    public $UserId;
    public $DeveloperUserId;
    public $Date;
    public $Content;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getMessagesByTicket(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE TicketId =:TicketId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TicketId", $this->TicketId);
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
                    AssistantId=:AssistantId,
                    UserId=:UserId,
                    DeveloperUserId=:DeveloperUserId,
                    Date=:Date,
                    Content=:Content";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TicketId=htmlspecialchars(strip_tags($this->TicketId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->Content=htmlspecialchars(strip_tags($this->Content));

        // привязка значений 
        $stmt->bindParam(":TicketId", $this->TicketId);
        $stmt->bindParam(":AssistantId", $this->AssistantId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":DeveloperUserId", $this->DeveloperUserId);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":Content", $this->Content);

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
                    AssistantId=:AssistantId,
                    UserId=:UserId,
                    DeveloperUserId=:DeveloperUserId,
                    Date=:Date,
                    Content=:Content
                WHERE
                    TicketMessageID = :TicketMessageID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TicketMessageID=htmlspecialchars(strip_tags($this->TicketMessageID));
        $this->TicketId=htmlspecialchars(strip_tags($this->TicketId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->Content=htmlspecialchars(strip_tags($this->Content));

        // привязка значений 
        $stmt->bindParam(":TicketMessageID", $this->TicketMessageID);
        $stmt->bindParam(":TicketId", $this->TicketId);
        $stmt->bindParam(":AssistantId", $this->AssistantId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":DeveloperUserId", $this->DeveloperUserId);

        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":Content", $this->Content);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE TicketMessageID =:TicketMessageID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->TicketMessageID=htmlspecialchars(strip_tags($this->TicketMessageID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":TicketMessageID", $this->TicketMessageID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>