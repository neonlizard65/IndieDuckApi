<?php
class ProfileComment{

    private $conn; //строка подключения
    private $table_name = 'ProfileComment'; //таблица

    public $ProfileCommentID;
    public $AuthorId;
    public $UserId;
    public $Content;
    public $Date;

    public function __construct($db) {
        $this->conn = $db; 
    }

    //Поиск комментов по профилю
    function getCommentsFromProfile(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserId =:UserId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":UserId", $this->UserId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    //Поиск по пользователю
    function getCommentsByAuthor(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE AuthorId =:AuthorId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorId", $this->AuthorId);

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
                    AuthorId=:AuthorId,
                    UserId=:UserId,
                    Content=:Content,
                    Date=:Date";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AuthorId=htmlspecialchars(strip_tags($this->AuthorId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Content=htmlspecialchars(strip_tags($this->Content));
        $this->Date=htmlspecialchars(strip_tags($this->Date));

        // привязка значений 
        $stmt->bindParam(":AuthorId", $this->AuthorId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":Content", $this->Content);
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
                    AuthorId=:AuthorId,
                    UserId=:UserId,
                    Content=:Content,
                    Date=:Date
                WHERE
                    ProfileCommentID = :ProfileCommentID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AuthorId=htmlspecialchars(strip_tags($this->AuthorId));
        $this->UserId=htmlspecialchars(strip_tags($this->UserId));
        $this->Content=htmlspecialchars(strip_tags($this->Content));
        $this->Date=htmlspecialchars(strip_tags($this->Date));
        $this->ProfileCommentID=htmlspecialchars(strip_tags($this->ProfileCommentID));

        // привязка значений 
        $stmt->bindParam(":AuthorId", $this->AuthorId);
        $stmt->bindParam(":UserId", $this->UserId);
        $stmt->bindParam(":Content", $this->Content);
        $stmt->bindParam(":Date", $this->Date);
        $stmt->bindParam(":ProfileCommentID", $this->ProfileCommentID);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE ProfileCommentID =:ProfileCommentID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ProfileCommentID=htmlspecialchars(strip_tags($this->ProfileCommentID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ProfileCommentID", $this->ProfileCommentID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}