<?php

class ProductPriceList{

    private $conn; //строка подключения
    private $table_name = 'ProductPriceList'; //таблица

    public $PriceListID;
    public $ProductId;
    public $PriceCIS;
    public $PriceEU; 
    public $PriceUS;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getPricesCIS(){
        $query = "SELECT ProductId, PriceCIS FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getPricesEU(){
        $query = "SELECT ProductId, PriceEU FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getPricesUS(){
        $query = "SELECT ProductId, PriceUS FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getPricesAll(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }
    function getPricesByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId"; 
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        $stmt->execute();       
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->PriceListID = $row['PriceListID'];
        $this->ProductId = $row['ProductId'];
        $this->PriceCIS = $row['PriceCIS'];
        $this->PriceEU = $row['PriceEU'];
        $this->PriceUS = $row['PriceUS'];
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    ProductId=:ProductId,
                    PriceCIS=:PriceCIS,
                    PriceEU=:PriceEU,
                    PriceUS=:PriceUS";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->PriceCIS=htmlspecialchars(strip_tags($this->PriceCIS));        
        $this->PriceEU=htmlspecialchars(strip_tags($this->PriceEU));
        $this->PriceUS=htmlspecialchars(strip_tags($this->PriceUS));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":PriceCIS", $this->PriceCIS);
        $stmt->bindParam(":PriceEU", $this->PriceEU);
        $stmt->bindParam(":PriceUS", $this->PriceUS);

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
                    PriceCIS=:PriceCIS,
                    PriceEU=:PriceEU,
                    PriceUS=:PriceUS
                WHERE
                    PriceListID = :PriceListID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->PriceCIS=htmlspecialchars(strip_tags($this->PriceCIS));        
        $this->PriceEU=htmlspecialchars(strip_tags($this->PriceEU));
        $this->PriceUS=htmlspecialchars(strip_tags($this->PriceUS));
        $this->PriceListID=htmlspecialchars(strip_tags($this->PriceListID));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":PriceCIS", $this->PriceCIS);
        $stmt->bindParam(":PriceEU", $this->PriceEU);
        $stmt->bindParam(":PriceUS", $this->PriceUS);
        $stmt->bindParam(":PriceListID", $this->PriceListID);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE PriceListID =:PriceListID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->PriceListID=htmlspecialchars(strip_tags($this->PriceListID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":PriceListID", $this->PriceListID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>