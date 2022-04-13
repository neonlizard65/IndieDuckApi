<?php

class Thread{

    private $conn; //строка подключения
    private $table_name = 'Thread'; //таблица

    public $ThreadID;
    public $ProductId;
    public $AuthorUserId;
    public $AuthorDevUserId;
    public $PostDate;
    public $Header;
    public $TextContent;

    public function __construct($db) { 
        //конструктор
        $this->conn = $db;  
    } 

    function getThreadByID(){
        $query = "SELECT g.ThreadID, g.ProductId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ThreadID = p.PostID
        WHERE ThreadID =:ThreadID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ThreadID", $this->ThreadID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->ThreadID = $row['ThreadID'];
        $this->ProductId = $row['ProductId'];
        $this->AuthorUserId = $row['AuthorUserId'];
        $this->AuthorDevUserId = $row['AuthorDevUserId'];
        $this->PostDate = $row['PostDate'];
        $this->Header = $row['Header'];
        $this->TextContent = $row['TextContent']; 
    }

    function getThreadBySearch($search){
        $query = "SELECT g.ThreadID, g.ProductId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ThreadID = p.PostID
        WHERE UPPER(p.Header)
        LIKE UPPER('%". $search . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getThreadByDeveloperUser(){
        $query = "SELECT g.ThreadID, g.ProductId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ThreadID = p.PostID
        WHERE p.AuthorDevUserId =:AuthorDevUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getThreadByUser(){
        $query = "SELECT g.ThreadID, g.ProductId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ThreadID = p.PostID
        WHERE p.AuthorUserId =:AuthorUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getThreadByProduct(){
        $query = "SELECT g.ThreadID, g.ProductId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ThreadID = p.PostID
        WHERE g.ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getThreadByDates($date1, $date2){
        $query = "SELECT g.ThreadID, g.ProductId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ThreadID = p.PostID
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

                    INSERT INTO Thread
                    SET 
                        ThreadID=@lastid,
                        ProductId=:ProductId;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));

        // привязка значений 
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ProductId", $this->ProductId);
        

        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
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
                    PostID = :ThreadID";

        $query2="UPDATE Thread 
                SET 
                    ProductId=:ProductId
                WHERE ThreadID =:ThreadID "
                ;

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->ThreadID=htmlspecialchars(strip_tags($this->ThreadID));
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));

        // привязка значений 
        $stmt->bindParam(":ThreadID", $this->ThreadID);
        $stmt2->bindParam(":ThreadID", $this->ThreadID);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ProductId", $this->ProductId);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE ThreadID =:ThreadID";
        $query2="DELETE FROM Post WHERE PostID =:ThreadID;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // очистка 
        $this->ThreadID=htmlspecialchars(strip_tags($this->ThreadID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ThreadID", $this->ThreadID);
        $stmt2->bindParam(":ThreadID", $this->ThreadID);

        // выполняем запрос 
        if ($stmt->execute()&&$stmt2->execute()) {
            return true;
        }

        return false;
    }

}
?>