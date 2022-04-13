<?php

class LibraryItem{ 

    private $conn; //строка подключения
    private $table_name = 'LibraryItem'; //таблица

    public $LibraryItemID;
    public $UserId;
    public $ProductId;
    public $CDKeyId;
    public $Content;
    public $Hours;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getGamesFromUser(){
        $query = "SELECT li.LibraryItemID, li.UserId, li.ProductId, li.CDKeyId, cd.Content, li.Hours FROM " . $this->table_name . " li 
        INNER JOIN CDKey cd ON li.CDKeyId = cd.CDKeyID 
        WHERE UserId =:UserId";
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
                    CDKeyId=:CDKeyId,
                    Hours=:Hours";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CDKeyId=htmlspecialchars(strip_tags($this->CDKeyId));
        $this->Hours=htmlspecialchars(strip_tags($this->Hours));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":CDKeyId", $this->CDKeyId);
        $stmt->bindParam(":Hours", $this->Hours);

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
                    CDKeyId=:CDKeyId,
                    Hours=:Hours
                WHERE
                    LibraryItemID = :LibraryItemID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->LibraryItemID=htmlspecialchars(strip_tags($this->LibraryItemID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CDKeyId=htmlspecialchars(strip_tags($this->CDKeyId));
        $this->Hours=htmlspecialchars(strip_tags($this->Hours));

        // привязка значений 
        $stmt->bindParam(":LibraryItemID", $this->LibraryItemID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":CDKeyId", $this->CDKeyId);
        $stmt->bindParam(":Hours", $this->Hours);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE LibraryItemID =:LibraryItemID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->LibraryItemID=htmlspecialchars(strip_tags($this->LibraryItemID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":LibraryItemID", $this->LibraryItemID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>