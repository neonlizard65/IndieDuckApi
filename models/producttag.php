<?php

class ProductTag{

    private $conn; //строка подключения
    private $table_name = 'ProductTag'; //таблица

    public $ProductTagID;
    public $ProductId;
    public $TagId; 

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getTagByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getProductByTag(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE TagId =:TagId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":TagId", $this->TagId);
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
                    TagId=:TagId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->TagId=htmlspecialchars(strip_tags($this->TagId));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":TagId", $this->TagId);

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
                    TagId=:TagId
                WHERE
                    ProductTagID = :ProductTagID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductTagID=htmlspecialchars(strip_tags($this->ProductTagID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->TagId=htmlspecialchars(strip_tags($this->TagId));

        // привязка значений 
        $stmt->bindParam(":ProductTagID", $this->ProductTagID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":TagId", $this->TagId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE ProductTagID =:ProductTagID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ProductTagID=htmlspecialchars(strip_tags($this->ProductTagID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ProductTagID", $this->ProductTagID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>