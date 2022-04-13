<?php

class CheckProduct{

    private $conn; //строка подключения
    private $table_name = 'CheckProduct'; //таблица

    public $CheckProductID; 
    public $ProductId;
    public $CheckId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getProductsByCheck(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE CheckId =:CheckId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CheckId", $this->CheckId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getChecksByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId";
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
                    ProductId=:ProductId,
                    CheckId=:CheckId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CheckId=htmlspecialchars(strip_tags($this->CheckId));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":CheckId", $this->CheckId);

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
                    CheckId=:CheckId
                WHERE
                    CheckProductID = :CheckProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->CheckProductID=htmlspecialchars(strip_tags($this->CheckProductID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CheckId=htmlspecialchars(strip_tags($this->CheckId));

        // привязка значений 
        $stmt->bindParam(":CheckProductID", $this->CheckProductID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":CheckId", $this->CheckId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE CheckProductID =:CheckProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->CheckProductID=htmlspecialchars(strip_tags($this->CheckProductID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":CheckProductID", $this->CheckProductID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>