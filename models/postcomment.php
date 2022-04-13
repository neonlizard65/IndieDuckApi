<?php

class PostComment{

    private $conn; //строка подключения
    private $table_name = 'PostComment'; //таблица

    public $PostCommentID;
    public $UserId; 
    public $DevUserId;
    public $PostId;
    public $Content;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getCommentsByPost(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE PostId =:PostId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getCommentsByUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getCommentsByDevUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE DevUserId =:DevUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DevUserId", $this->DevUserId);
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
                    DevUserId=:DevUserId,
                    PostId=:PostId,
                    Content=:Content";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PostId=htmlspecialchars(strip_tags($this->PostId));
        $this->Content=htmlspecialchars(strip_tags($this->Content));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":DevUserId", $this->DevUserId);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":Content", $this->Content);

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
                    DevUserId=:DevUserId,
                    PostId=:PostId,
                    Content=:Content
                WHERE
                    PostCommentID = :PostCommentID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PostCommentID=htmlspecialchars(strip_tags($this->PostCommentID));
        $this->PostId=htmlspecialchars(strip_tags($this->PostId));
        $this->Content=htmlspecialchars(strip_tags($this->Content));

        // привязка значений 
        $stmt->bindParam(":PostCommentID", $this->PostCommentID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":DevUserId", $this->DevUserId);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":Content", $this->Content);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE PostCommentID =:PostCommentID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->PostCommentID=htmlspecialchars(strip_tags($this->PostCommentID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":PostCommentID", $this->PostCommentID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>