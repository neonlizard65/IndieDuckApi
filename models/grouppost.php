<?php

class GroupPost{

    private $conn; //строка подключения
    private $table_name = 'GroupPost'; //таблица

    public $GroupPostID;
    public $GroupId;
    public $AuthorUserId;
    public $AuthorDevUserId;
    public $PostDate;
    public $Header;
    public $TextContent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getGroupPostByID(){
        $query = "SELECT g.GroupPostID, g.GroupId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.GroupPostID = p.PostID
        WHERE GroupPostID =:GroupPostID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":GroupPostID", $this->GroupPostID);
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->GroupPostID = $row['GroupPostID']; 
        $this->GroupId = $row['GroupId'];
        $this->AuthorUserId = $row['AuthorUserId'];
        $this->AuthorDevUserId = $row['AuthorDevUserId'];
        $this->PostDate = $row['PostDate'];
        $this->Header = $row['Header'];
        $this->TextContent = $row['TextContent']; 
    }

    function getGroupPostBySearch($search){
        $query = "SELECT g.GroupPostID, g.GroupId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.GroupPostID = p.PostID
        WHERE UPPER(p.Header)
        LIKE UPPER('%". $search . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getGroupPostByDeveloperUser(){
        $query = "SELECT g.GroupPostID, g.GroupId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.GroupPostID = p.PostID
        WHERE p.AuthorDevUserId =:AuthorDevUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getGroupPostByUser(){
        $query = "SELECT g.GroupPostID, g.GroupId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.GroupPostID = p.PostID
        WHERE p.AuthorUserId =:AuthorUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getGroupPostByGroup(){
        $query = "SELECT g.GroupPostID, g.GroupId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.GroupPostID = p.PostID
        WHERE g.GroupId =:GroupId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":GroupId", $this->GroupId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getGroupPostByDates($date1, $date2){
        $query = "SELECT g.GroupPostID, g.GroupId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.GroupPostID = p.PostID
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

                    INSERT INTO GroupPost
                    SET 
                        GroupPostID=@lastid,
                        GroupId=:GroupId;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // очисткa
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->GroupId=htmlspecialchars(strip_tags($this->GroupId));

        // привязка значений 
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":GroupId", $this->GroupId);
        

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
                    PostID = :GroupPostID";

        $query2="UPDATE GroupPost 
                SET 
                    GroupId=:GroupId
                WHERE GroupPostID =:GroupPostID "
                ;

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->GroupPostID=htmlspecialchars(strip_tags($this->GroupPostID));
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->GroupId=htmlspecialchars(strip_tags($this->GroupId));

        // привязка значений 
        $stmt->bindParam(":GroupPostID", $this->GroupPostID);
        $stmt2->bindParam(":GroupPostID", $this->GroupPostID);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":GroupId", $this->GroupId);

        // выполняем запрос 
        if ($stmt->execute()&&$stmt2->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE GroupPostID =:GroupPostID;
        DELETE FROM Post WHERE PostID =:GroupPostID;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->GroupPostID=htmlspecialchars(strip_tags($this->GroupPostID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":GroupPostID", $this->GroupPostID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>