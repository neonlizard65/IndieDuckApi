<?php
class Achievement{
    private $conn; //строка подключения
    private $table_name = 'Achievement'; //таблица

    public $AchievementID;
    public $ProductId;
    public $Name;
    public $Image;
    public $Description;
    public $XP;
    public $IsHidden;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getAchievementByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;

    }
    
    function getAchievementByID(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE AchievementID =:AchievementID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AchievementID", $this->AchievementID);
     
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->AchievementID = $row['AchievementID'];
        $this->ProductId = $row['ProductId'];
        $this->Name = $row['Name'];
        $this->Image = $row['Image'];
        $this->Description = $row['Description'];
        $this->XP = $row['XP'];
        $this->IsHidden = $row['IsHidden'];
    }

    // метод create - создание
    function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    ProductId=:ProductId,
                    Name=:Name,
                    Image=:Image,
                    Description=:Description,
                    XP=:XP,
                    IsHidden=:IsHidden";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->Image=htmlspecialchars(strip_tags($this->Image));
        $this->Description=htmlspecialchars(strip_tags($this->Description));
        $this->XP=htmlspecialchars(strip_tags($this->XP));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Image", $this->Image);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":XP", $this->XP);
        $stmt->bindParam(":IsHidden", $this->IsHidden);

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
                    ProductId=:ProductId,
                    Name=:Name,
                    Image=:Image,
                    Description=:Description,
                    XP=:XP,
                    IsHidden=:IsHidden
                WHERE
                    AchievementID = :AchievementID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AchievementID=htmlspecialchars(strip_tags($this->AchievementID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->Image=htmlspecialchars(strip_tags($this->Image));
        $this->Description=htmlspecialchars(strip_tags($this->Description));
        $this->XP=htmlspecialchars(strip_tags($this->XP)); 
        // привязка значений 
        $stmt->bindParam(":AchievementID", $this->AchievementID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":Image", $this->Image);
        $stmt->bindParam(":Description", $this->Description);
        $stmt->bindParam(":XP", $this->XP);
        $stmt->bindParam(":IsHidden", $this->IsHidden);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE AchievementID =:AchievementID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->AchievementID=htmlspecialchars(strip_tags($this->AchievementID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":AchievementID", $this->AchievementID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}

?>