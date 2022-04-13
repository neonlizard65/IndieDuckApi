<?php

class BundleProduct{

    private $conn; //строка подключения
    private $table_name = 'BundleProduct'; //таблица

    public $BundleProductID;
    public $BundleId;
    public $ProductId;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getProductsFromBundle(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE BundleId =:BundleId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":BundleId", $this->BundleId);
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
                    BundleId=:BundleId,
                    ProductId=:ProductId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->BundleId=htmlspecialchars(strip_tags($this->BundleId));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));

        // привязка значений 
        $stmt->bindParam(":BundleId", $this->BundleId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        
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
                    BundleId=:BundleId,
                    ProductId=:ProductId
                WHERE
                    BundleProductID = :BundleProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->BundleProductID=htmlspecialchars(strip_tags($this->BundleProductID));
        $this->BundleId=htmlspecialchars(strip_tags($this->BundleId));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));

        // привязка значений 
        $stmt->bindParam(":BundleProductID", $this->BundleProductID);
        $stmt->bindParam(":BundleId", $this->BundleId);
        $stmt->bindParam(":ProductId", $this->ProductId);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE BundleProductID =:BundleProductID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->BundleProductID=htmlspecialchars(strip_tags($this->BundleProductID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":BundleProductID", $this->BundleProductID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>