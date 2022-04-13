<?php

class DLC{

    private $conn; //строка подключения
    private $table_name = 'DLC'; //таблица

    public $DLCID;
    public $GameId;
    public $Name;
    public $ReleaseDate;
    public $DeveloperId;
    public $PublisherId;
    public $Discount;
    public $ShortBio;
    public $About;
    public $FranchiseId;
    public $FranchiseName;
    public $AgeRatingESRB;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getDLCByID(){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.Franchise = f.FranchiseID
        WHERE d.DLCID =: DLCID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DLCID", $this->DLCID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->DLCID = $row['DLCID'];
        $this->GameId = $row['GameId'];
        $this->Name = $row['Name'];
        $this->ReleaseDate = $row['ReleaseDate'];
        $this->DeveloperId = $row['DeveloperId'];
        $this->PublisherId = $row['PublisherId'];
        $this->Discount = $row['Discount'];
        $this->ShortBio = $row['ShortBio'];
        $this->About = $row['About'];
        $this->FranchiseId = $row['FranchiseId'];
        $this->FranchiseName = $row['FranchiseName'];
        $this->AgeRatingESRB = $row['AgeRatingESRB'];
    }
    function getDLCByGame(){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE d.GameId =:GameId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":GameId", $this->GameId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDLCBySearch($search){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d 
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE UPPER(p.Name)
        LIKE UPPER('%". $search . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDLCByDeveloper(){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE p.DeveloperId =:DeveloperId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDLCByPublisher(){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d 
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE p.PublisherId =:PublisherId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PublisherId", $this->PublisherId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDLCByFranchise(){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE p.FranchiseId =:FranchiseId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":FranchiseId", $this->FranchiseId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDLCByDiscount($mindiscount){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE p.Discount >= " . $mindiscount;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDLCByDates($date1, $date2){
        $query = "SELECT d.DLCID, d.GameId, p.Name, p.ReleaseDate, p.DeveloperId, p.PublisherId, p.Discount, p.ShortBio, p.About,
        p.FranchiseId, f.FranchiseName, p.AgeRatingESRB FROM " . $this->table_name . " d
        INNER JOIN Product p ON d.DLCID = p.ProductID 
        LEFT JOIN Franchise f ON p.FranchiseId = f.FranchiseID
        WHERE p.ReleaseDate >= " . $date1 . "
        AND p.ReleaseDate <= " . $date2;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO Product 
                  SET
                    Name=:Name,
                    ReleaseDate=:ReleaseDate,
                    DeveloperId=:DeveloperId,
                    PublisherId=:PublisherId,
                    Discount=:Discount,
                    ShortBio=:ShortBio,
                    About=:About,
                    FranchiseId=:FranchiseId,
                    AgeRatingESRB=:AgeRatingESRB;";
                    
        $query2 = "  SET @lastid = (SELECT ProductID from Product ORDER BY ProductID DESC LIMIT 1);

        INSERT INTO DLC
        SET 
            DLCID=@lastid,
            GameId=:GameId;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->GameId=htmlspecialchars(strip_tags($this->GameId));
        $this->ReleaseDate=htmlspecialchars(strip_tags($this->ReleaseDate));        
        $this->DeveloperId=htmlspecialchars(strip_tags($this->DeveloperId));
        $this->PublisherId=htmlspecialchars(strip_tags($this->PublisherId));
        $this->Discount=htmlspecialchars(strip_tags($this->Discount));
        $this->ShortBio=htmlspecialchars(strip_tags($this->ShortBio));
        $this->About=htmlspecialchars(strip_tags($this->About));$this->AgeRatingESRB=htmlspecialchars(strip_tags($this->AgeRatingESRB));

        // привязка значений 
        $stmt->bindParam(":Name", $this->Name);
        $stmt2->bindParam(":GameId", $this->GameId);
        $stmt->bindParam(":ReleaseDate", $this->ReleaseDate);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        $stmt->bindParam(":PublisherId", $this->PublisherId);
        $stmt->bindParam(":Discount", $this->Discount);
        $stmt->bindParam(":ShortBio", $this->ShortBio);
        $stmt->bindParam(":About", $this->About);
        $stmt->bindParam(":FranchiseId", $this->FranchiseId);
        $stmt->bindParam(":AgeRatingESRB", $this->AgeRatingESRB);

        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }
        return false;
    }

    //обновление групп
    function update(){
        // запрос для вставки (создания) записей 
        $query = "UPDATE Product
                SET
                    Name=:Name,
                    ReleaseDate=:ReleaseDate,
                    DeveloperId=:DeveloperId,
                    PublisherId=:PublisherId,
                    Discount=:Discount,
                    ShortBio=:ShortBio,
                    About=:About,
                    FranchiseId=:FranchiseId,
                    AgeRatingESRB=:AgeRatingESRB
                WHERE
                    ProductID = :DLCID;";
        $query2 = "UPDATE DLC 
                SET 
                    GameId=:GameId 
                WHERE DLCID =:DLCID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);
        // очисткa
        $this->DLCID=htmlspecialchars(strip_tags($this->DLCID));
        $this->GameId=htmlspecialchars(strip_tags($this->GameId));
        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->ReleaseDate=htmlspecialchars(strip_tags($this->ReleaseDate));        
        $this->DeveloperId=htmlspecialchars(strip_tags($this->DeveloperId));
        $this->PublisherId=htmlspecialchars(strip_tags($this->PublisherId));
        $this->Discount=htmlspecialchars(strip_tags($this->Discount));
        $this->ShortBio=htmlspecialchars(strip_tags($this->ShortBio));
        $this->About=htmlspecialchars(strip_tags($this->About));
          $this->AgeRatingESRB=htmlspecialchars(strip_tags($this->AgeRatingESRB));

        // привязка значений 
        $stmt->bindParam(":DLCID", $this->DLCID);
        $stmt2->bindParam(":DLCID", $this->DLCID);
        $stmt2->bindParam(":GameId", $this->GameId);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":ReleaseDate", $this->ReleaseDate);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        $stmt->bindParam(":PublisherId", $this->PublisherId);
        $stmt->bindParam(":Discount", $this->Discount);
        $stmt->bindParam(":ShortBio", $this->ShortBio);
        $stmt->bindParam(":About", $this->About);
        $stmt->bindParam(":FranchiseId", $this->FranchiseId);
        $stmt->bindParam(":AgeRatingESRB", $this->AgeRatingESRB);

        // выполняем запрос 
        if ($stmt->execute() && $stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE DLCID =:DLCID;";
        $query2="DELETE FROM Product WHERE ProductID =:DLCID;";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt2 = $this->conn->prepare($query2);

        // очистка 
        $this->DLCID=htmlspecialchars(strip_tags($this->DLCID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":DLCID", $this->DLCID);
        $stmt2->bindParam(":DLCID", $this->DLCID);

        // выполняем запрос 
        if ($stmt->execute() && $stmt2->execute()) {
            return true;
        }

        return false;
    }

}
?>