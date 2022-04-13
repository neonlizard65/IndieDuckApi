<?php

class Franchise{

    private $conn; //строка подключения
    private $table_name = 'Franchise'; //таблица

    public $FranchiseID;
    public $FranchiseName;
    public $FranchiseImage; 


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getFranchises(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

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
                    FranchiseName=:FranchiseName,
                    FranchiseImage=:FranchiseImage";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->FranchiseName=htmlspecialchars(strip_tags($this->FranchiseName));
        $this->FranchiseImage=htmlspecialchars(strip_tags($this->FranchiseImage));

        // привязка значений 
        $stmt->bindParam(":FranchiseName", $this->FranchiseName);
        $stmt->bindParam(":FranchiseImage", $this->FranchiseImage);

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
                    FranchiseName=:FranchiseName,
                    FranchiseImage=:FranchiseImage
                WHERE
                    FranchiseID = :FranchiseID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->FranchiseID=htmlspecialchars(strip_tags($this->FranchiseID));
        $this->FranchiseName=htmlspecialchars(strip_tags($this->FranchiseName));
        $this->FranchiseImage=htmlspecialchars(strip_tags($this->FranchiseImage));

        // привязка значений 
        $stmt->bindParam(":FranchiseID", $this->FranchiseID);
        $stmt->bindParam(":FranchiseName", $this->FranchiseName);
        $stmt->bindParam(":FranchiseImage", $this->FranchiseImage);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE FranchiseID =:FranchiseID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->FranchiseID=htmlspecialchars(strip_tags($this->FranchiseID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":FranchiseID", $this->FranchiseID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>