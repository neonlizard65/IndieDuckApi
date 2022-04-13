<?php
class Message{

    private $conn; //строка подключения
    private $table_name = 'Message'; //таблица

    //Message
    public $MessageID;
    public $TextContent;
    public $UserId;
    public $ChatId;
    public $Date;

    public function __construct($db) {
        $this->conn = $db; 
    }

    //Поиск по чату
    function getMessagesFromChat(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ChatId =:ChatId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ChatId", $this->ChatId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    //Поиск по пользователю
    function getMessageFromUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
        
    //Поиск по чату
    function getUserMessagesFromChat(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ChatId =:ChatId AND UserId =:UserId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ChatId", $this->ChatId);
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
                    TextContent=:TextContent,
                    UserId=:UserId,
                    ChatId=:ChatId,
                    Date=:Date";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ChatId=htmlspecialchars(strip_tags($this->ChatId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ChatId", $this->ChatId);
        $stmt->bindParam(":Date", $this->Date);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //обновление
    function update(){
        // запрос для вставки (создания) записей 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    TextContent=:TextContent,
                    UserId=:UserId,
                    ChatId=:ChatId,
                    Date=:Date
                WHERE
                    MessageID = :MessageID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ChatId=htmlspecialchars(strip_tags($this->ChatId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->MessageID=htmlspecialchars(strip_tags($this->MessageID));

        // привязка значений 
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ChatId", $this->ChatId);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":MessageID", $this->MessageID);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE MessageID =:MessageID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->MessageID=htmlspecialchars(strip_tags($this->MessageID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":MessageID", $this->MessageID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}