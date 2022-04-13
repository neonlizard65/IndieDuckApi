<?php

class UserCoupon{

    private $conn; //строка подключения
    private $table_name = 'UserCoupon'; //таблица

    public $UserCouponID;
    public $UserId;
    public $CouponId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getCouponByUser(){ 
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
                    CouponId=:CouponId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->CouponId=htmlspecialchars(strip_tags($this->CouponId));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":CouponId", $this->CouponId);

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
                    CouponId=:CouponId
                WHERE
                    UserCouponID = :UserCouponID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserCouponID=htmlspecialchars(strip_tags($this->UserCouponID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->CouponId=htmlspecialchars(strip_tags($this->CouponId));

        // привязка значений 
        $stmt->bindParam(":UserCouponID", $this->UserCouponID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":CouponId", $this->CouponId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserCouponID =:UserCouponID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->UserCouponID=htmlspecialchars(strip_tags($this->UserCouponID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserCouponID", $this->UserCouponID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>