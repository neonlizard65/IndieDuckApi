<?php

class UserLike{ 

    private $conn; //строка подключения
    private $table_name = 'UserLike'; //таблица

    public $UserLikeID;
    public $UserId;
    public $PostId;
    public $CommentId;
    public $ContestGameId;
    public $LikeDislike;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    function getLikesByPost(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE PostId =:PostId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getLikesCountByPost(){
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE PostId =:PostId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getDislikesByPost(){
        $query = "SELECT * FROM " . $this->table_name . "  WHERE PostId =:PostId AND LikeDislike = 1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getDislikesCountByPost(){
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE PostId =:PostId AND LikeDislike = 1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PostId", $this->PostId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getLikesByComment(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE CommentId =:CommentId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CommentId", $this->CommentId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getLikesCountByComment(){
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE CommentId =:CommentId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CommentId", $this->CommentId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getDislikesByComment(){
        $query = "SELECT * FROM " . $this->table_name . "  WHERE CommentId =:CommentId AND LikeDislike = 1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CommentId", $this->CommentId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getDislikesCountByComment(){
        $query = "SELECT COUNT(*) FROM " . $this->table_name . "  WHERE CommentId =:CommentId AND LikeDislike = 1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CommentId", $this->CommentId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getLikesByContestGame(){
        $query = "SELECT * FROM " . $this->table_name . "  WHERE ContestGameId =:ContestGameId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ContestGameId", $this->ContestGameId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    
    function getLikesCountByContestGame(){
        $query = "SELECT COUNT(*) FROM " . $this->table_name . "  WHERE ContestGameId =:ContestGameId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ContestGameId", $this->ContestGameId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getLikesFromUser(){
        $query = "SELECT * FROM " . $this->table_name . "  WHERE UserId =:UserId AND LikeDislike = 0";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

     // метод create - создание
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    UserId=:UserId,
                    PostId=:PostId,
                    CommentId=:CommentId,
                    ContestGameId=:ContestGameId,
                    LikeDislike=:LikeDislike";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->LikeDislike=htmlspecialchars(strip_tags($this->LikeDislike));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":CommentId", $this->CommentId);
        $stmt->bindParam(":ContestGameId", $this->ContestGameId);
        $stmt->bindParam(":LikeDislike", $this->LikeDislike);

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
                    PostId=:PostId,
                    CommentId=:CommentId,
                    ContestGameId=:ContestGameId,
                    LikeDislike=:LikeDislike
                WHERE
                    UserLikeID = :UserLikeID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserLikeID=htmlspecialchars(strip_tags($this->UserLikeID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->LikeDislike=htmlspecialchars(strip_tags($this->LikeDislike));

        // привязка значений 
        $stmt->bindParam(":UserLikeID", $this->UserLikeID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":PostId", $this->PostId);
        $stmt->bindParam(":CommentId", $this->CommentId);
        $stmt->bindParam(":ContestGameId", $this->ContestGameId);
        $stmt->bindParam(":LikeDislike", $this->LikeDislike);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserLikeID =:UserLikeID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->UserLikeID=htmlspecialchars(strip_tags($this->UserLikeID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserLikeID", $this->UserLikeID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>