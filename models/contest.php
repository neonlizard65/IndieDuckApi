<?php
class Contest{
    private $conn; //строка подключения
    private $table_name = 'Contest'; //таблица

    public $ContestID;
    public $ContestImage;
    public $ContestName;
    public $StartDate;
    public $EndDate;
    public $DeveloperWinner;
    public $UserWinner;
    public $UserXPReward;
    public $DevMoneyReward;
    public $ContestDescription;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getAllContests(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getContestBySearch($search){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ContestName LIKE '%" . $search . "%'";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    
    function getContestByID(){ 
        $query = "SELECT * FROM " . $this->table_name . " WHERE ContestID =:ContestID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("ContestID", $this->ContestID);
        // выполняем запрос 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->ContestID = $row['ContestID'];
        $this->ContestName = $row['ContestName'];
        $this->ContestImage = $row['ContestImage'];
        $this->StartDate = $row['StartDate'];
        $this->EndDate = $row['EndDate'];
        $this->DeveloperWinner = $row['DeveloperWinner'];
        $this->UserWinner = $row['UserWinner'];
        $this->UserXPReward = $row['UserXPReward'];
        $this->DevMoneyReward = $row['DevMoneyReward'];
        $this->ContestDescription = $row['ContestDescription'];
    }

    function getOngoingContest(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE NOW() < EndDate AND NOW() > StartDate";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
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
                    ContestName=:ContestName,
                    ContestImage=:ContestImage,
                    StartDate=:StartDate,
                    EndDate=:EndDate,
                    DeveloperWinner=:DeveloperWinner,
                    UserWinner=:UserWinner,
                    UserXPReward=:UserXPReward,
                    DevMoneyReward=:DevMoneyReward,
                    ContestDescription=:ContestDescription";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ContestName=htmlspecialchars(strip_tags($this->ContestName));
        $this->ContestImage=htmlspecialchars(strip_tags($this->ContestImage));
        $this->StartDate=htmlspecialchars(strip_tags($this->StartDate));
        $this->EndDate=htmlspecialchars(strip_tags($this->EndDate));
        $this->ContestDescription=htmlspecialchars(strip_tags($this->ContestDescription));

        // привязка значений 
        $stmt->bindParam(":ContestName", $this->ContestName);
        $stmt->bindParam(":ContestImage", $this->ContestImage);
        $stmt->bindParam(":StartDate", $this->StartDate);
        $stmt->bindParam(":EndDate", $this->EndDate);
        $stmt->bindParam(":DeveloperWinner", $this->DeveloperWinner);
        $stmt->bindParam(":UserWinner", $this->UserWinner);
        $stmt->bindParam(":UserXPReward", $this->UserXPReward);
        $stmt->bindParam(":DevMoneyReward", $this->DevMoneyReward);
        $stmt->bindParam(":ContestDescription", $this->ContestDescription);

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
                    ContestName=:ContestName,
                    ContestImage=:ContestImage,
                    StartDate=:StartDate,
                    EndDate=:EndDate,
                    DeveloperWinner=:DeveloperWinner,
                    UserWinner=:UserWinner,
                    UserXPReward=:UserXPReward,
                    DevMoneyReward=:DevMoneyReward,
                    ContestDescription=:ContestDescription
                WHERE
                    ContestID = :ContestID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ContestID=htmlspecialchars(strip_tags($this->ContestID));
        $this->ContestName=htmlspecialchars(strip_tags($this->ContestName));
        $this->ContestImage=htmlspecialchars(strip_tags($this->ContestImage));
        $this->StartDate=htmlspecialchars(strip_tags($this->StartDate));
        $this->EndDate=htmlspecialchars(strip_tags($this->EndDate));
        $this->ContestDescription=htmlspecialchars(strip_tags($this->ContestDescription));

        // привязка значений 
        $stmt->bindParam(":ContestID", $this->ContestID);
        $stmt->bindParam(":ContestName", $this->ContestName);
        $stmt->bindParam(":ContestImage", $this->ContestImage);
        $stmt->bindParam(":StartDate", $this->StartDate);
        $stmt->bindParam(":EndDate", $this->EndDate);
        $stmt->bindParam(":DeveloperWinner", $this->DeveloperWinner);
        $stmt->bindParam(":UserWinner", $this->UserWinner);
        $stmt->bindParam(":UserXPReward", $this->UserXPReward);
        $stmt->bindParam(":DevMoneyReward", $this->DevMoneyReward);
        $stmt->bindParam(":ContestDescription", $this->ContestDescription);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE ContestID =:ContestID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ContestID=htmlspecialchars(strip_tags($this->ContestID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ContestID", $this->ContestID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}

?>