<?php
class ChatUser{
    private $conn; //строка подключения 
    private $table_name = 'ChatUser'; //таблица

    public $ChatUserID;
    public $ChatId;
    public $UserId;
    public $RoleId;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getUsersFromChat(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ChatId =:ChatId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("ChatId", $this->ChatId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getChatsFromUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
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
                    ChatId=:ChatId,
                    UserId=:UserId,
                    RoleId=:RoleId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // привязка значений 
        $stmt->bindParam(":ChatId", $this->ChatId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":RoleId", $this->RoleId);

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
                    ChatId=:ChatId,
                    UserId=:UserId,
                    RoleId=:RoleId
                WHERE
                    ChatUserID = :ChatUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);


        // привязка значений 
        $stmt->bindParam(":ChatId", $this->ChatId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":RoleId", $this->RoleId);
        $stmt->bindParam(":ChatUserID", $this->ChatUserID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE ChatUserID =:ChatUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ChatUserID=htmlspecialchars(strip_tags($this->ChatUserID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ChatUserID", $this->ChatUserID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>