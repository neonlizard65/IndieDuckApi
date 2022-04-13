<?php

class Check{

    private $conn; //строка подключения
    private $table_name = 'indieduck.Check'; //таблица

    public $CheckID;
    public $UserId;
    public $UserCouponId;
    public $Total;
    public $IsGift;
    public $UserReceiverId;
    public $IsRefunded;
    public $Date;
    public $ProductId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getCheckByUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getCheckByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " c INNER JOIN CheckProduct cp ON c.CheckID = cp.CheckId WHERE cp.ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
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
                    UserCouponId=:UserCouponId,
                    Total=:Total,
                    IsGift=:IsGift,
                    UserReceiverId=:UserReceiverId,
                    IsRefunded=:IsRefunded,
                    Date=:Date";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":UserCouponId", $this->UserCouponId);
        $stmt->bindParam(":Total", $this->Total);
        $stmt->bindParam(":IsGift", $this->IsGift);
        $stmt->bindParam(":UserReceiverId", $this->UserReceiverId);
        $stmt->bindParam(":IsRefunded", $this->IsRefunded);
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
                    UserCouponId=:UserCouponId,
                    Total=:Total,
                    IsGift=:IsGift,
                    UserReceiverId=:UserReceiverId,
                    IsRefunded=:IsRefunded,
                    Date=:Date
                WHERE
                    CheckID = :CheckID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->CheckID=htmlspecialchars(strip_tags($this->CheckID));
        $this->Total=htmlspecialchars(strip_tags($this->Total));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":CheckID", $this->CheckID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":UserCouponId", $this->UserCouponId);
        $stmt->bindParam(":Total", $this->Total);
        $stmt->bindParam(":IsGift", $this->IsGift);
        $stmt->bindParam(":UserReceiverId", $this->UserReceiverId);
        $stmt->bindParam(":IsRefunded", $this->IsRefunded);
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
        $query = "DELETE FROM " . $this->table_name . " WHERE CheckID =:CheckID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->CheckID=htmlspecialchars(strip_tags($this->CheckID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":CheckID", $this->CheckID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>