<?php

class ContestPost{

    private $conn; //строка подключения
    private $table_name = 'ContestPost'; //таблица

    public $ContestPostID;
    public $ContestId;
    public $AuthorUserId;
    public $AuthorDevUserId;
    public $PostDate;
    public $Header;
    public $TextContent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getContestPostByID(){
        $query = "SELECT g.ContestPostID, g.ContestId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ContestPostID = p.PostID
        WHERE ContestPostID =:ContestPostID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ContestPostID", $this->ContestPostID);
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->ContestPostID = $row['ContestPostID']; 
        $this->ContestId = $row['ContestId'];
        $this->AuthorUserId = $row['AuthorUserId'];
        $this->AuthorDevUserId = $row['AuthorDevUserId'];
        $this->PostDate = $row['PostDate'];
        $this->Header = $row['Header'];
        $this->TextContent = $row['TextContent']; 
    }

    function getContestPostBySearch($search){
        $query = "SELECT g.ContestPostID, g.ContestId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ContestPostID = p.PostID
        WHERE UPPER(p.Header)
        LIKE UPPER('%". $search . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getContestPostByDeveloperUser(){
        $query = "SELECT g.ContestPostID, g.ContestId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ContestPostID = p.PostID
        WHERE p.AuthorDevUserId =:AuthorDevUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getContestPostByUser(){
        $query = "SELECT g.ContestPostID, g.ContestId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ContestPostID = p.PostID
        WHERE p.AuthorUserId =:AuthorUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getContestPostByContest(){
        $query = "SELECT g.ContestPostID, g.ContestId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ContestPostID = p.PostID
        WHERE g.ContestId =:ContestId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ContestId", $this->ContestId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getContestPostByDates($date1, $date2){
        $query = "SELECT g.ContestPostID, g.ContestId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ContestPostID = p.PostID
        WHERE p.PostDate >= " . $date1 . "
        AND p.PostDate <= " . $date2;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO Post 
                  SET
                    AuthorUserId=:AuthorUserId,
                    AuthorDevUserId=:AuthorDevUserId,
                    PostDate=:PostDate,
                    Header=:Header,
                    TextContent=:TextContent";
                    
        $query2 = "SET @lastid = (SELECT PostID from Post ORDER BY PostID DESC LIMIT 1);

                    INSERT INTO ContestPost
                    SET 
                        ContestPostID=@lastid,
                        ContestId=:ContestId;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ContestId=htmlspecialchars(strip_tags($this->ContestId));

        // привязка значений 
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ContestId", $this->ContestId);
        

        // выполняем запрос 
        if ($stmt->execute()&&$stmt2->execute()) {
            return true;
        }
        return false;
    }

    //обновление групп
    function update(){
        // запрос для вставки (создания) записей 
        $query = "UPDATE Post
                SET
                    AuthorUserId=:AuthorUserId,
                    AuthorDevUserId=:AuthorDevUserId,
                    PostDate=:PostDate,
                    Header=:Header,
                    TextContent=:TextContent
                WHERE
                    PostID = :ContestPostID";

        $query2 = "UPDATE ContestPost 
                SET 
                    ContestId=:ContestId
                WHERE ContestPostID =:ContestPostID "
                ;

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // очисткa
        $this->ContestPostID=htmlspecialchars(strip_tags($this->ContestPostID));
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ContestId=htmlspecialchars(strip_tags($this->ContestId));

        // привязка значений 
        $stmt->bindParam(":ContestPostID", $this->ContestPostID);
        $stmt2->bindParam(":ContestPostID", $this->ContestPostID);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ContestId", $this->ContestId);

        // выполняем запрос 
        if ($stmt->execute()&&$stmt2->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE ContestPostID =:ContestPostID";
        $query2= "DELETE FROM Post WHERE PostID =:ContestPostID;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очистка 
        $this->ContestPostID=htmlspecialchars(strip_tags($this->ContestPostID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ContestPostID", $this->ContestPostID);
        $stmt2->bindParam(":ContestPostID", $this->ContestPostID);
        // выполняем запрос 
        if ($stmt->execute()&&$stmt2->execute()) {
            return true;
        }

        return false;
    }

}
?>