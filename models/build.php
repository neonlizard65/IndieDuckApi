<?php

class Build{

    private $conn; //строка подключения
    private $table_name = 'Build'; //таблица

    public $BuildID;
    public $ProductId;
    public $DeveloperUserId;
    public $Version;
    public $Date;
    public $BuildContent;
    public $IsDemo;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getBuildFromProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
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
                    ProductId=:ProductId,
                    DeveloperUserId=:DeveloperUserId,
                    Version=:Version,
                    Date=:Date,
                    BuildContent=:BuildContent,
                    IsDemo=:IsDemo";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->DeveloperUserId=htmlspecialchars(strip_tags($this->DeveloperUserId));
        $this->Version=htmlspecialchars(strip_tags($this->Version));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->BuildContent=htmlspecialchars(strip_tags($this->BuildContent));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":DeveloperUserId", $this->DeveloperUserId);
        $stmt->bindParam(":Version", $this->Version);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":BuildContent", $this->BuildContent);
        $stmt->bindParam(":IsDemo", $this->IsDemo);

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
                    ProductId=:ProductId,
                    DeveloperUserId=:DeveloperUserId,
                    Version=:Version,
                    Date=:Date,
                    BuildContent=:BuildContent,
                    IsDemo=:IsDemo
                WHERE
                    BuildID = :BuildID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->BuildID=htmlspecialchars(strip_tags($this->BuildID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->DeveloperUserId=htmlspecialchars(strip_tags($this->DeveloperUserId));
        $this->Version=htmlspecialchars(strip_tags($this->Version));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->BuildContent=htmlspecialchars(strip_tags($this->BuildContent));

        // привязка значений 
        $stmt->bindParam(":BuildID", $this->BuildID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":DeveloperUserId", $this->DeveloperUserId);
        $stmt->bindParam(":Version", $this->Version);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":BuildContent", $this->BuildContent);
        $stmt->bindParam(":IsDemo", $this->IsDemo);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE BuildID =:BuildID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->BuildID=htmlspecialchars(strip_tags($this->BuildID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":BuildID", $this->BuildID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>