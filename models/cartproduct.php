<?php

class CartProduct{

    private $conn; //строка подключения
    private $table_name = 'CartProduct'; //таблица

    public $CartProductID;
    public $ProductId;
    public $UserId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getCartProductsByUser(){
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
                    CartProductID = :CartProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->CartProductID=htmlspecialchars(strip_tags($this->CartProductID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));

        // привязка значений 
        $stmt->bindParam(":CartProductID", $this->CartProductID);
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
        $query = "DELETE FROM " . $this->table_name . " WHERE CartProductID =:CartProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->CartProductID=htmlspecialchars(strip_tags($this->CartProductID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":CartProductID", $this->CartProductID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>