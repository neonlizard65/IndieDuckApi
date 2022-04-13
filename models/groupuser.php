<?php
class GroupUser{

    private $conn;
     private $table_name = "GroupUser";

    public $GroupUserID;
    public $GroupId;
    public $UserId;
    public $GroupRole;	

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getAllGroupsAndUsers(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getUsersByGroup(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE GroupId =:GroupId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":GroupId", $this->GroupId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getGroupsByUser(){
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
                    UserId=:UserId,
                    GroupId=:GroupId,
                    GroupRole=:GroupRole";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->GroupId=htmlspecialchars(strip_tags($this->GroupId));
        $this->GroupRole=htmlspecialchars(strip_tags($this->GroupRole));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":GroupId", $this->GroupId);
        $stmt->bindParam(":GroupRole", $this->GroupRole);

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
                    GroupId=:GroupId,
                    GroupRole=:GroupRole
                WHERE
                    GroupUserID = :GroupUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->GroupUserID=htmlspecialchars(strip_tags($this->GroupUserID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->GroupId=htmlspecialchars(strip_tags($this->GroupId));
        $this->GroupRole=htmlspecialchars(strip_tags($this->GroupRole));

        // привязка значений 
        $stmt->bindParam(":GroupUserID", $this->GroupUserID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":GroupId", $this->GroupId);
        $stmt->bindParam(":GroupRole", $this->GroupRole);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE GroupUserID =:GroupUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->GroupUserID=htmlspecialchars(strip_tags($this->GroupUserID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":GroupUserID", $this->GroupUserID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>