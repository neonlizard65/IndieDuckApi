<?php

class PostMedia{

    private $conn; //строка подключения
    private $table_name = 'PostMedia'; //таблица

    public $PostMediaID;
    public $PostId; 
    public $MediaContent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getMediaByPost(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE PostId =:PostId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
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
                    PostId=:PostId,
                    MediaContent=:MediaContent";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PostId=htmlspecialchars(strip_tags($this->PostId));
        $this->MediaContent=htmlspecialchars(strip_tags($this->MediaContent));

        // привязка значений 
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":MediaContent", $this->MediaContent);

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
                    PostId=:PostId,
                    MediaContent=:MediaContent
                WHERE
                    PostMediaID = :PostMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PostMediaID=htmlspecialchars(strip_tags($this->PostMediaID));
        $this->PostId=htmlspecialchars(strip_tags($this->PostId));
        $this->MediaContent=htmlspecialchars(strip_tags($this->MediaContent));

        // привязка значений 
        $stmt->bindParam(":PostMediaID", $this->PostMediaID);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":MediaContent", $this->MediaContent);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE PostMediaID =:PostMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->PostMediaID=htmlspecialchars(strip_tags($this->PostMediaID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":PostMediaID", $this->PostMediaID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>