<?php

class CrowdfundCheck{

    private $conn; //строка подключения
    private $table_name = 'CrowdfundCheck'; //таблица

    public $CrowdfundCheckID;
    public $UserId;
    public $IsGift;
    public $UserReceiverId;
    public $Sum;
    public $Date;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getCrowdfundCheckByUser(){ 
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
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
                    IsGift=:IsGift,
                    UserReceiverId=:UserReceiverId,
                    Sum=:Sum,
                    Date=:Date";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Sum=htmlspecialchars(strip_tags($this->Sum));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":IsGift", $this->IsGift);
        $stmt->bindParam(":UserReceiverId", $this->UserReceiverId);
        $stmt->bindParam(":Sum", $this->Sum);
        $stmt->bindParam(":Date", $this->Date);

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
                    IsGift=:IsGift,
                    UserReceiverId=:UserReceiverId,
                    Sum=:Sum,
                    Date=:Date
                WHERE
                    CrowdfundCheckID = :CrowdfundCheckID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->CrowdfundCheckID=htmlspecialchars(strip_tags($this->CrowdfundCheckID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Sum=htmlspecialchars(strip_tags($this->Sum));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":CrowdfundCheckID", $this->CrowdfundCheckID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":IsGift", $this->IsGift);
        $stmt->bindParam(":UserReceiverId", $this->UserReceiverId);
        $stmt->bindParam(":Sum", $this->Sum);
        $stmt->bindParam(":Date", $this->Date);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE CrowdfundCheckID =:CrowdfundCheckID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->CrowdfundCheckID=htmlspecialchars(strip_tags($this->CrowdfundCheckID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":CrowdfundCheckID", $this->CrowdfundCheckID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>