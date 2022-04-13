<?php

class UserNewsPreference{

    private $conn; //строка подключения
    private $table_name = 'UserNewsPreference'; //таблица

    public $UserNewsPreferenceID;
    public $UserId;
    public $DeveloperId;
    public $PublisherId;
    public $ProductId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getPreferenceByUser(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId); 
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
                    UserId=:UserId,
                    DeveloperId=:DeveloperId,
                    PublisherId=:PublisherId,
                    ProductId=:ProductId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
     

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        $stmt->bindParam(":PublisherId", $this->PublisherId);
        $stmt->bindParam(":ProductId", $this->ProductId);

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
                    DeveloperId=:DeveloperId,
                    PublisherId=:PublisherId,
                    ProductId=:ProductId
                WHERE
                    UserNewsPreferenceID = :UserNewsPreferenceID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserNewsPreferenceID=htmlspecialchars(strip_tags($this->UserNewsPreferenceID));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
       

        // привязка значений 
        $stmt->bindParam(":UserNewsPreferenceID", $this->UserNewsPreferenceID);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        $stmt->bindParam(":PublisherId", $this->PublisherId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserNewsPreferenceID =:UserNewsPreferenceID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->UserNewsPreferenceID=htmlspecialchars(strip_tags($this->UserNewsPreferenceID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserNewsPreferenceID", $this->UserNewsPreferenceID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    

}
?>