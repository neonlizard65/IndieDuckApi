<?php

class ProductMedia{

    private $conn; //строка подключения
    private $table_name = 'ProductMedia'; //таблица

    public $ProductMediaID;
    public $ProductId;
    public $Media; 

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    } 

    function getMediaByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
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
                    Media=:Media";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Media=htmlspecialchars(strip_tags($this->Media));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":Media", $this->Media);

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
                    Media=:Media
                WHERE
                    ProductMediaID = :ProductMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductMediaID=htmlspecialchars(strip_tags($this->ProductMediaID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->Media=htmlspecialchars(strip_tags($this->Media));

        // привязка значений 
        $stmt->bindParam(":ProductMediaID", $this->ProductMediaID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":Media", $this->Media);
        

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE ProductMediaID =:ProductMediaID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ProductMediaID=htmlspecialchars(strip_tags($this->ProductMediaID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ProductMediaID", $this->ProductMediaID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>