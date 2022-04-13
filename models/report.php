<?php

class Report{

    private $conn; //строка подключения
    private $table_name = 'Report'; //таблица

    public $ReportID;
    public $UserId;
    public $ReportedUserId;
    public $ReportedProductId;
    public $ReportedPostId;
    public $ReportReasonId;
    public $AdditionalInfo;
    public $IsResolved;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getAllReports(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    
    // не решенные
    function getUnresolvedReports(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE IsResolved = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

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
                    ReportedUserId=:ReportedUserId,
                    ReportedProductId=:ReportedProductId,
                    ReportedPostId=:ReportedPostId,
                    ReportReasonId=:ReportReasonId,
                    AdditionalInfo=:AdditionalInfo,
                    IsResolved=0";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->AdditionalInfo=htmlspecialchars(strip_tags($this->AdditionalInfo));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ReportedUserId", $this->ReportedUserId);
        $stmt->bindParam(":ReportedProductId", $this->ReportedProductId);
        $stmt->bindParam(":ReportedPostId", $this->ReportedPostId);
        $stmt->bindParam(":ReportReasonId", $this->ReportReasonId);
        $stmt->bindParam(":AdditionalInfo", $this->AdditionalInfo);

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
                    ReportedUserId=:ReportedUserId,
                    ReportedProductId=:ReportedProductId,
                    ReportedPostId=:ReportedPostId,
                    ReportReasonId=:ReportReasonId,
                    AdditionalInfo=:AdditionalInfo,
                    IsResolved=:IsResolved
                WHERE
                    ReportID = :ReportID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ReportID=htmlspecialchars(strip_tags($this->ReportID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ReportReasonId=htmlspecialchars(strip_tags($this->ReportReasonId));
        $this->AdditionalInfo=htmlspecialchars(strip_tags($this->AdditionalInfo));

        // привязка значений 
        $stmt->bindParam(":ReportID", $this->ReportID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ReportedUserId", $this->ReportedUserId);
        $stmt->bindParam(":ReportedProductId", $this->ReportedProductId);
        $stmt->bindParam(":ReportedPostId", $this->ReportedPostId);
        $stmt->bindParam(":ReportReasonId", $this->ReportReasonId);
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
        $query = "DELETE FROM " . $this->table_name . " WHERE ReportID =:ReportID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ReportID=htmlspecialchars(strip_tags($this->ReportID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ReportID", $this->ReportID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>