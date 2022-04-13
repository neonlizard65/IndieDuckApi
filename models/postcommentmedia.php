<?php

class PostCommentMedia{ 

    private $conn; //строка подключения
    private $table_name = 'PostCommentMedia'; //таблица

    public $PostCommentMediaID;
    public $PostCommentId;
    public $MediaContent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getMediaByPostComment(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE PostCommentId =:PostCommentId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostCommentId", $this->PostCommentId);
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
                    PostCommentId=:PostCommentId,
                    MediaContent=:MediaContent";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PostCommentId=htmlspecialchars(strip_tags($this->PostCommentId));
        $this->MediaContent=htmlspecialchars(strip_tags($this->MediaContent));

        // привязка значений 
        $stmt->bindParam(":PostCommentId", $this->PostCommentId);
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
                    PostCommentId=:PostCommentId,
                    MediaContent=:MediaContent
                WHERE
                    PostCommentMediaID = :PostCommentMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PostCommentMediaID=htmlspecialchars(strip_tags($this->PostCommentMediaID));
        $this->PostCommentId=htmlspecialchars(strip_tags($this->PostCommentId));
        $this->MediaContent=htmlspecialchars(strip_tags($this->MediaContent));

        // привязка значений 
        $stmt->bindParam(":PostCommentMediaID", $this->PostCommentMediaID);
        $stmt->bindParam(":PostCommentId", $this->PostCommentId);
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
        $query = "DELETE FROM " . $this->table_name . " WHERE PostCommentMediaID =:PostCommentMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->PostCommentMediaID=htmlspecialchars(strip_tags($this->PostCommentMediaID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":PostCommentMediaID", $this->PostCommentMediaID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>