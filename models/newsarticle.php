<?php

class NewsArticle{

    private $conn; //строка подключения
    private $table_name = 'NewsArticle'; //таблица

    public $NewsArticleID;
    public $ProductId;
    public $PublisherId;
    public $DeveloperId;
    public $AuthorUserId;
    public $AuthorDevUserId;
    public $PostDate;
    public $Header;
    public $TextContent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getNewsArticleByID(){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE NewsArticleID =:NewsArticleID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":NewsArticleID", $this->NewsArticleID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->NewsArticleID = $row['NewsArticleID'];
        $this->ProductId = $row['ProductId'];
        $this->PublisherId = $row['PublisherId'];
        $this->DeveloperId = $row['DeveloperId'];
        $this->Rating = $row['Rating'];
        $this->AuthorDevUserId = $row['AuthorDevUserId'];
        $this->PostDate = $row['PostDate'];
        $this->Header = $row['Header'];
        $this->TextContent = $row['TextContent']; 
    }
    
    function getNewsArticleBySearch($search){ 
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE UPPER(p.Header)
        LIKE UPPER('%". $search . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getNewsArticleByDeveloper(){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE g.DeveloperId =:DeveloperId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getNewsArticleByPublisher(){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId,   p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE g.PublisherId =:PublisherId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PublisherId", $this->PublisherId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getNewsArticleByDeveloperUser(){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId,   p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE p.AuthorDevUserId =:AuthorDevUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getNewsArticleByUser(){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId,   p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE p.AuthorUserId =:AuthorUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getNewsArticleByProduct(){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId,  p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
        WHERE g.ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getNewsArticleByDates($date1, $date2){
        $query = "SELECT g.NewsArticleID, g.ProductId, g.PublisherId, g.DeveloperId,  p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.NewsArticleID = p.PostID
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

                    INSERT INTO NewsArticle
                    SET 
                        NewsArticleID=@lastid,
                        ProductId=:ProductId,
                        PublisherId =:PublisherId,
                        DeveloperId=:DeveloperId;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->PublisherId=htmlspecialchars(strip_tags($this->PublisherId));
        $this->DeveloperId=htmlspecialchars(strip_tags($this->DeveloperId));
        
        // привязка значений 
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ProductId", $this->ProductId);
        $stmt2->bindParam(":PublisherId", $this->PublisherId);
        $stmt2->bindParam(":DeveloperId", $this->DeveloperId);

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
                    PostID = :NewsArticleID";

        $query2="UPDATE NewsArticle 
                SET 
                    ProductId=:ProductId,
                    PublisherId =:PublisherId,
                    DeveloperId=:DeveloperId
                WHERE NewsArticleID =:NewsArticleID"
                ;

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->NewsArticleID=htmlspecialchars(strip_tags($this->NewsArticleID));
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->PublisherId=htmlspecialchars(strip_tags($this->PublisherId));
        $this->DeveloperId=htmlspecialchars(strip_tags($this->DeveloperId));

        // привязка значений 
        $stmt->bindParam(":NewsArticleID", $this->NewsArticleID);
        $stmt2->bindParam(":NewsArticleID", $this->NewsArticleID);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":AuthorDevUserId", $this->AuthorDevUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ProductId", $this->ProductId);
        $stmt2->bindParam(":PublisherId", $this->PublisherId);
        $stmt2->bindParam(":DeveloperId", $this->DeveloperId);

        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }
        return false; 
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE NewsArticleID =:NewsArticleID";
        $query2 = "DELETE FROM Post WHERE PostID =:NewsArticleID;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очистка 
        $this->NewsArticleID=htmlspecialchars(strip_tags($this->NewsArticleID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":NewsArticleID", $this->NewsArticleID);
        $stmt2->bindParam(":NewsArticleID", $this->NewsArticleID);


        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }

        return false;
    }

}
?>