<?php
class UserFriend{

    private $conn; //строка подключения
    private $table_name = 'UserFriend'; //таблица

    public $UserFriendID;
    public $UserId;
    public $FriendId;
    public $IsSent;
    public $IsAccepted;
    public $IsBlocked;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getFriendsByUser(){ 
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId AND IsAccepted = 1";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getOutgoingFriendRequests(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId AND IsSent = 1 AND IsAccepted = 0";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getIncomingFriendRequests(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE FriendId =:FriendId AND IsSent = 1 AND IsAccepted = 0";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":FriendId", $this->FriendId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getBlockedUsersByUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId AND IsBlocked = 1";
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
                    FriendId=:FriendId,
                    IsSent=:IsSent,
                    IsAccepted=:IsAccepted,
                    IsBlocked=:IsBlocked";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->FriendId=htmlspecialchars(strip_tags($this->FriendId));
        $this->IsSent=htmlspecialchars(strip_tags($this->IsSent));
        $this->IsAccepted=htmlspecialchars(strip_tags($this->IsAccepted));
        $this->IsBlocked=htmlspecialchars(strip_tags($this->IsBlocked));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":FriendId", $this->FriendId);
        $stmt->bindParam(":IsSent", $this->IsSent);
        $stmt->bindParam(":IsAccepted", $this->IsAccepted);
        $stmt->bindParam(":IsBlocked", $this->IsBlocked);

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
                    UserId=:UserId,
                    FriendId=:FriendId,
                    IsSent=:IsSent,
                    IsAccepted=:IsAccepted,
                    IsBlocked=:IsBlocked
                WHERE
                    UserFriendID = :UserFriendID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->FriendId=htmlspecialchars(strip_tags($this->FriendId));
        $this->IsSent=htmlspecialchars(strip_tags($this->IsSent));
        $this->IsAccepted=htmlspecialchars(strip_tags($this->IsAccepted));
        $this->IsBlocked=htmlspecialchars(strip_tags($this->IsBlocked));
        $this->UserFriendID=htmlspecialchars(strip_tags($this->UserFriendID));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":FriendId", $this->FriendId);
        $stmt->bindParam(":IsSent", $this->IsSent);
        $stmt->bindParam(":IsAccepted", $this->IsAccepted);
        $stmt->bindParam(":IsBlocked", $this->IsBlocked);
        $stmt->bindParam(":UserFriendID", $this->UserFriendID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserFriendID =:UserFriendID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->UserFriendID=htmlspecialchars(strip_tags($this->UserFriendID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserFriendID", $this->UserFriendID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}