<?php

class SupportTicket{

    private $conn; //строка подключения
    private $table_name = 'SupportTicket'; //таблица 

    public $SupportTicketID;
    public $UserId;
    public $ProductId;
    public $TicketReasonId;
    public $TicketReasonText;
    public $AdditionalInfo;
    public $IsResolved;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getAllSupportTickets(){
        $query = "SELECT st.SupportTicketID, st.UserId, st.ProductId, st.TicketReasonId, tr.Name, st.AdditionalInfo, st.IsResolved  
        FROM " . $this->table_name . " st INNER JOIN TicketReason tr ON st.TicketReasonId = tr.TicketReasonID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getUnresolvedSupportTickets(){
        $query = "SELECT st.SupportTicketID, st.UserId, st.ProductId, st.TicketReasonId, tr.Name, st.AdditionalInfo, st.IsResolved  
        FROM " . $this->table_name . " st INNER JOIN TicketReason tr ON st.TicketReasonId = tr.TicketReasonID WHERE st.IsResolved = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function getSupportTicketsByProduct(){
        $query = "SELECT st.SupportTicketID, st.UserId, st.ProductId, st.TicketReasonId, tr.Name, st.AdditionalInfo, st.IsResolved  
        FROM " . $this->table_name . " st INNER JOIN TicketReason tr ON st.TicketReasonId = tr.TicketReasonID WHERE st.ProductId=:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt; 
    }
    function getSupportTicketsByUser(){
        $query = "SELECT st.SupportTicketID, st.UserId, st.ProductId, st.TicketReasonId, tr.Name, st.AdditionalInfo, st.IsResolved  
        FROM " . $this->table_name . " st INNER JOIN TicketReason tr ON st.TicketReasonId = tr.TicketReasonID WHERE st.UserId=:UserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
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
                    UserId=:UserId,
                    ProductId=:ProductId,
                    TicketReasonId=:TicketReasonId,
                    AdditionalInfo =:AdditionalInfo,
                    IsResolved =:IsResolved";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->TicketReasonId=htmlspecialchars(strip_tags($this->TicketReasonId));
        $this->AdditionalInfo=htmlspecialchars(strip_tags($this->AdditionalInfo));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":TicketReasonId", $this->TicketReasonId);
        $stmt->bindParam(":AdditionalInfo", $this->AdditionalInfo);
        $stmt->bindParam(":IsResolved", $this->IsResolved);
        
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
                    UserId=:UserId,
                    ProductId=:ProductId,
                    TicketReasonId=:TicketReasonId,
                    AdditionalInfo =:AdditionalInfo,
                    IsResolved =:IsResolved 
                WHERE
                    SupportTicketID =:SupportTicketID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->SupportTicketID=htmlspecialchars(strip_tags($this->SupportTicketID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->TicketReasonId=htmlspecialchars(strip_tags($this->TicketReasonId));
        $this->AdditionalInfo=htmlspecialchars(strip_tags($this->AdditionalInfo));

        // привязка значений 
        $stmt->bindParam(":SupportTicketID", $this->SupportTicketID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":TicketReasonId", $this->TicketReasonId);
        $stmt->bindParam(":AdditionalInfo", $this->AdditionalInfo);
        $stmt->bindParam(":IsResolved", $this->IsResolved);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE SupportTicketID =:SupportTicketID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->SupportTicketID=htmlspecialchars(strip_tags($this->SupportTicketID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":SupportTicketID", $this->SupportTicketID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>