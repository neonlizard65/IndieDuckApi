<?php

class Assistant{

    private $conn; //строка подключения
    private $table_name = 'Assistant'; //таблица

    public $AssistantID;
    public $AssistantUserName;
    public $AssistantRealName;
    public $AssistantPass;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все
    function getAssistants(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    // по логину
    function getAssistantByUserName(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE AssistantUserName=:AssistantUserName LIMIT 0,1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":AssistantUserName", $this->AssistantUserName);

        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->AssistantID = $row['AssistantID'];
        $this->AssistantUserName = $row['AssistantUserName'];
        $this->AssistantRealName = $row['AssistantRealName'];
        $this->AssistantPass = $row['AssistantPass'];
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    AssistantUserName=:AssistantUserName,
                    AssistantRealName=:AssistantRealName,
                    AssistantPass=:AssistantPass";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AssistantUserName=htmlspecialchars(strip_tags($this->AssistantUserName));
        $this->AssistantRealName=htmlspecialchars(strip_tags($this->AssistantRealName));
        $this->AssistantPass=htmlspecialchars(strip_tags($this->AssistantPass));

        // привязка значений 
        $stmt->bindParam(":AssistantUserName", $this->AssistantUserName);
        $stmt->bindParam(":AssistantRealName", $this->AssistantRealName);
        $stmt->bindParam(":AssistantPass", $this->AssistantPass);

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
                    AssistantUserName=:AssistantUserName,
                    AssistantRealName=:AssistantRealName,
                    AssistantPass=:AssistantPass
                WHERE
                    AssistantID = :AssistantID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->AssistantID=htmlspecialchars(strip_tags($this->AssistantID));
        $this->AssistantUserName=htmlspecialchars(strip_tags($this->AssistantUserName));
        $this->AssistantRealName=htmlspecialchars(strip_tags($this->AssistantRealName));
        $this->AssistantPass=htmlspecialchars(strip_tags($this->AssistantPass));

        // привязка значений 
        $stmt->bindParam(":AssistantID", $this->AssistantID);
        $stmt->bindParam(":AssistantUserName", $this->AssistantUserName);
        $stmt->bindParam(":AssistantRealName", $this->AssistantRealName);
        $stmt->bindParam(":AssistantPass", $this->AssistantPass);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE AssistantID =:AssistantID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->AssistantID=htmlspecialchars(strip_tags($this->AssistantID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":AssistantID", $this->AssistantID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>