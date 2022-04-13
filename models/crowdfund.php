<?php

class Crowdfund{

    private $conn; //строка подключения
    private $table_name = 'Crowdfund'; //таблица

    public $CrowdfundID;
    public $ProductId;
    public $CurrentSum;
    public $Goal;
    public $MinSumForGame;
    public $EndDate;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }


    function getCrowdfundFromProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
        // все
    function getAllCrowdfunds(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    ProductId=:ProductId,
                    CurrentSum=:CurrentSum,
                    Goal=:Goal,
                    MinSumForGame=:MinSumForGame,
                    EndDate=:EndDate";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CurrentSum=htmlspecialchars(strip_tags($this->CurrentSum));
        $this->Goal=htmlspecialchars(strip_tags($this->Goal));
        $this->MinSumForGame=htmlspecialchars(strip_tags($this->MinSumForGame));
        $this->EndDate=htmlspecialchars(strip_tags($this->EndDate));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":CurrentSum", $this->CurrentSum);
        $stmt->bindParam(":Goal", $this->Goal);
        $stmt->bindParam(":MinSumForGame", $this->MinSumForGame);
        $stmt->bindParam(":EndDate", $this->EndDate);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //обновление групп
    function update(){
        // запрос для вставки (создания) записей 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    ProductId=:ProductId,
                    CurrentSum=:CurrentSum,
                    Goal=:Goal,
                    MinSumForGame=:MinSumForGame,
                    EndDate=:EndDate
                WHERE
                    CrowdfundID = :CrowdfundID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->CrowdfundID=htmlspecialchars(strip_tags($this->CrowdfundID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CurrentSum=htmlspecialchars(strip_tags($this->CurrentSum));
        $this->Goal=htmlspecialchars(strip_tags($this->Goal));
        $this->MinSumForGame=htmlspecialchars(strip_tags($this->MinSumForGame));
        $this->EndDate=htmlspecialchars(strip_tags($this->EndDate));

        // привязка значений 
        $stmt->bindParam(":CrowdfundID", $this->CrowdfundID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":CurrentSum", $this->CurrentSum);
        $stmt->bindParam(":Goal", $this->Goal);
        $stmt->bindParam(":MinSumForGame", $this->MinSumForGame);
        $stmt->bindParam(":EndDate", $this->EndDate);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE CrowdfundID =:CrowdfundID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->CrowdfundID=htmlspecialchars(strip_tags($this->CrowdfundID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":CrowdfundID", $this->CrowdfundID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>