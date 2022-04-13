<?php

class Review{

    private $conn; //строка подключения
    private $table_name = 'Review'; //таблица

    public $ReviewID; 
    public $ProductId;
    public $Rating;
    public $AuthorUserId;
    public $AuthorDevUserId;
    public $PostDate;
    public $Header;
    public $TextContent;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getReviewByID(){
        $query = "SELECT g.ReviewID, g.ProductId, g.Rating, p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ReviewID = p.PostID
        WHERE ReviewID =:ReviewID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ReviewID", $this->ReviewID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        // установим значения свойств объекта 
        $this->ReviewID = $row['ReviewID'];
        $this->ProductId = $row['ProductId'];
        $this->Rating = $row['Rating'];
        $this->AuthorUserId = $row['AuthorUserId'];
        $this->AuthorDevUserId = $row['AuthorDevUserId'];
        $this->PostDate = $row['PostDate'];
        $this->Header = $row['Header'];
        $this->TextContent = $row['TextContent']; 
    }

    function getReviewByRating(){
        $query = "SELECT g.ReviewID, g.ProductId, g.Rating,  p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ReviewID = p.PostID
        WHERE g.Rating =:Rating AND g.ProductId=:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":Rating", $this->Rating);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getReviewByUser(){
        $query = "SELECT g.ReviewID, g.ProductId, g.Rating,  p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ReviewID = p.PostID
        WHERE p.AuthorUserId =:AuthorUserId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getReviewByProduct(){
        $query = "SELECT g.ReviewID, g.ProductId, g.Rating,  p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ReviewID = p.PostID
        WHERE g.ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getReviewByDates($date1, $date2){
        $query = "SELECT g.ReviewID, g.ProductId, g.Rating,  p.AuthorUserId, p.AuthorDevUserId, p.PostDate, p.Header, p.TextContent FROM " . $this->table_name . " g
        INNER JOIN Post p ON g.ReviewID = p.PostID
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
                    PostDate=:PostDate,
                    Header=:Header,
                    TextContent=:TextContent";
                    
        $query2="SET @lastid = (SELECT PostID from Post ORDER BY PostID DESC LIMIT 1);

                    INSERT INTO Review
                    SET 
                        ReviewID=@lastid,
                        ProductId=:ProductId,
                        Rating =:Rating;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Rating=htmlspecialchars(strip_tags($this->Rating));

        // привязка значений 
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ProductId", $this->ProductId);
        $stmt2->bindParam(":Rating", $this->Rating);
        

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
                    PostDate=:PostDate,
                    Header=:Header,
                    TextContent=:TextContent
                WHERE
                    PostID = :ReviewID";

        $query2 = "UPDATE Review 
                SET 
                    ProductId=:ProductId,
                    Rating =:Rating
                WHERE ReviewID =:ReviewID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->ReviewID=htmlspecialchars(strip_tags($this->ReviewID));
        $this->PostDate=htmlspecialchars(strip_tags($this->PostDate));        
        $this->Header=htmlspecialchars(strip_tags($this->Header));
        $this->TextContent=htmlspecialchars(strip_tags($this->TextContent));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));

        // привязка значений 
        $stmt->bindParam(":ReviewID", $this->ReviewID);
        $stmt->bindParam(":AuthorUserId", $this->AuthorUserId);
        $stmt->bindParam(":PostDate", $this->PostDate);
        $stmt->bindParam(":Header", $this->Header);
        $stmt->bindParam(":TextContent", $this->TextContent);
        $stmt2->bindParam(":ProductId", $this->ProductId);
        $stmt2->bindParam(":Rating", $this->Rating);
        $stmt2->bindParam(":ReviewID", $this->ReviewID);

        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE ReviewID =:ReviewID";
        $query2 = "DELETE FROM Post WHERE PostID =:ReviewID;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // очистка 
        $this->ReviewID=htmlspecialchars(strip_tags($this->ReviewID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ReviewID", $this->ReviewID);
        $stmt2->bindParam(":ReviewID", $this->ReviewID);
        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }

        return false;
    }

}
?>