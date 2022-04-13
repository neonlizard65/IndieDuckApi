<?php

class WishlistProduct{

    private $conn; //строка подключения
    private $table_name = 'WishlistProduct'; //таблица

    public $WishlistProductID;
    public $ProductId;
    public $UserId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getWishlistProductsByUser(){
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
                    ProductId=:ProductId,
                    UserId=:UserId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":UserId", $this->UserId);

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
                    ProductId=:ProductId,
                    UserId=:UserId
                WHERE
                    WishlistProductID = :WishlistProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->WishlistProductID=htmlspecialchars(strip_tags($this->WishlistProductID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));

        // привязка значений 
        $stmt->bindParam(":WishlistProductID", $this->WishlistProductID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":UserId", $this->UserId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE WishlistProductID =:WishlistProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->WishlistProductID=htmlspecialchars(strip_tags($this->WishlistProductID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":WishlistProductID", $this->WishlistProductID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>