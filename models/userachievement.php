<?php

class UserAchievement{

    private $conn; //строка подключения
    private $table_name = 'UserAchievement'; //таблица

    public $UserAchievementID;
    public $AchievementId;
    public $UserId;
    public $ProductId;
    public $Date;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getUserAchievementsByUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt; 
    }

    function getUserAchievementsByUserProduct(){
        $query = "SELECT * FROM " . $this->table_name . " ua INNER JOIN Achievement a ON ua.AchievementId = a.AchievementID
         WHERE UserId =:UserId AND ProductId=:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
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
                    AchievementId=:AchievementId,
                    UserId=:UserId,
                    Date=:Date";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AchievementId=htmlspecialchars(strip_tags($this->AchievementId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        // привязка значений 
        $stmt->bindParam(":AchievementId", $this->AchievementId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":Date", $this->Date);
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
                    AchievementId=:AchievementId,
                    UserId=:UserId,
                    Date=:Date
                WHERE
                    UserAchievementID = :UserAchievementID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserAchievementID=htmlspecialchars(strip_tags($this->UserAchievementID));
        $this->AchievementId=htmlspecialchars(strip_tags($this->AchievementId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":UserAchievementID", $this->UserAchievementID);
        $stmt->bindParam(":AchievementId", $this->AchievementId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":Date", $this->Date);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserAchievementID =:UserAchievementID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->UserAchievementID=htmlspecialchars(strip_tags($this->UserAchievementID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserAchievementID", $this->UserAchievementID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>