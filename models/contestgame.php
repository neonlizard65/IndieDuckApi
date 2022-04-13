<?php

class ContestGame{

    private $conn; //строка подключения
    private $table_name = 'ContestGame'; //таблица

    public $ContestGameID;
    public $ContestId;
    public $GameId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getGamesByContest(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ContestId =:ContestId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ContestId", $this->ContestId);
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
                    ContestId=:ContestId,
                    GameId=:GameId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ContestId=htmlspecialchars(strip_tags($this->ContestId));
        $this->GameId=htmlspecialchars(strip_tags($this->GameId));

        // привязка значений 
        $stmt->bindParam(":ContestId", $this->ContestId);
        $stmt->bindParam(":GameId", $this->GameId);

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
                    ContestId=:ContestId,
                    GameId=:GameId
                WHERE
                    ContestGameID = :ContestGameID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ContestGameID=htmlspecialchars(strip_tags($this->ContestGameID));
        $this->ContestId=htmlspecialchars(strip_tags($this->ContestId));
        $this->GameId=htmlspecialchars(strip_tags($this->GameId));

        // привязка значений 
        $stmt->bindParam(":ContestGameID", $this->ContestGameID);
        $stmt->bindParam(":ContestId", $this->ContestId);
        $stmt->bindParam(":GameId", $this->GameId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE ContestGameID =:ContestGameID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ContestGameID=htmlspecialchars(strip_tags($this->ContestGameID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ContestGameID", $this->ContestGameID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>