<?php

class Publisher{

    private $conn; //строка подключения
    private $table_name = 'Publisher'; //таблица

    public $PublisherID;
     public $PublisherName;
    public $PublisherLogo;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getPublishers(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getPublisherByID(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE PublisherID=:PublisherID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":PublisherID", $this->PublisherID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->PublisherID = $row['PublisherID'];
        $this->PublisherName = $row['PublisherName'];
        $this->PublisherLogo = $row['PublisherLogo'];
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    PublisherName=:PublisherName,
                    PublisherLogo=:PublisherLogo";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PublisherName=htmlspecialchars(strip_tags($this->PublisherName));
        $this->PublisherLogo=htmlspecialchars(strip_tags($this->PublisherLogo));

        // привязка значений 
        $stmt->bindParam(":PublisherName", $this->PublisherName);
        $stmt->bindParam(":PublisherLogo", $this->PublisherLogo);

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
                    PublisherName=:PublisherName,
                    PublisherLogo=:PublisherLogo
                WHERE
                    PublisherID = :PublisherID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->PublisherID=htmlspecialchars(strip_tags($this->PublisherID));
        $this->PublisherName=htmlspecialchars(strip_tags($this->PublisherName));
        $this->PublisherLogo=htmlspecialchars(strip_tags($this->PublisherLogo));

        // привязка значений 
        $stmt->bindParam(":PublisherID", $this->PublisherID);
        $stmt->bindParam(":PublisherName", $this->PublisherName);
        $stmt->bindParam(":PublisherLogo", $this->PublisherLogo);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE PublisherID =:PublisherID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->PublisherID=htmlspecialchars(strip_tags($this->PublisherID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":PublisherID", $this->PublisherID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>