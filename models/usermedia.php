<?php
class UserMedia{

    private $conn; //строка подключения
    private $table_name = 'UserMedia'; //таблица

    public $UserMediaID;
    public $UserId;
    public $ProductId;
    public $Content;
    public $Date; 
    public $Title;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getAllUserMedia(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getUserMediaByGame(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId AND ProductId=:ProductId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
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
                    ProductId=:ProductId,
                    Content=:Content,
                    Date=:Date,
                    Title=:Title";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Content=htmlspecialchars(strip_tags($this->Content));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->Title=htmlspecialchars(strip_tags($this->Title));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":Content", $this->Content);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":Title", $this->Title);

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
                    ProductId=:ProductId,
                    Content=:Content,
                    Date=:Date,
                    Title=:Title
                WHERE
                    UserMediaID = :UserMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Content=htmlspecialchars(strip_tags($this->Content));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->Title=htmlspecialchars(strip_tags($this->Title));
        $this->UserMediaID=htmlspecialchars(strip_tags($this->UserMediaID));

        // привязка значений 
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":Content", $this->Content);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":Title", $this->Title);
        $stmt->bindParam(":UserMediaID", $this->UserMediaID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserMediaID =:UserMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->UserMediaID=htmlspecialchars(strip_tags($this->UserMediaID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserMediaID", $this->UserMediaID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}