<?php

class DeveloperUser{

    private $conn; //строка подключения
    private $table_name = 'DeveloperUser'; //таблица

    public $DeveloperUserID;
    public $DeveloperUserName;
    public $DeveloperUserPass;
    public $DeveloperUserEmail;
    public $DeveloperUserGuardCode;
    public $DeveloperId;
    public $IsAdmin;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getAllDeveloperUsers(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDeveloperUsersByDeveloper(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE DeveloperId =:DeveloperId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getDeveloperUserByName(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE DeveloperUserName=:DeveloperUserName";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DeveloperUserName", $this->DeveloperUserName);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->DeveloperUserID = $row['DeveloperUserID'];
        $this->DeveloperUserName = $row['DeveloperUserName'];
        $this->DeveloperUserPass = $row['DeveloperUserPass'];
        $this->DeveloperUserEmail = $row['DeveloperUserEmail'];
        $this->DeveloperUserGuardCode = $row['DeveloperUserGuardCode'];
        $this->DeveloperId = $row['DeveloperId'];
        $this->IsAdmin = $row['IsAdmin'];

    }

    function getDeveloperUserByEmail(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE DeveloperUserEmail=:DeveloperUserEmail";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DeveloperUserEmail", $this->DeveloperUserEmail);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->DeveloperUserID = $row['DeveloperUserID'];
        $this->DeveloperUserName = $row['DeveloperUserName'];
        $this->DeveloperUserPass = $row['DeveloperUserPass'];
        $this->DeveloperUserEmail = $row['DeveloperUserEmail'];
        $this->DeveloperUserGuardCode = $row['DeveloperUserGuardCode'];
        $this->IsAdmin = $row['IsAdmin'];
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    DeveloperUserName=:DeveloperUserName,
                    DeveloperUserPass=:DeveloperUserPass,
                    DeveloperUserEmail=:DeveloperUserEmail,
                    DeveloperId=:DeveloperId,
                    IsAdmin=:IsAdmin";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->DeveloperUserName=htmlspecialchars(strip_tags($this->DeveloperUserName));
        $this->DeveloperUserPass=htmlspecialchars(strip_tags($this->DeveloperUserPass));
        $this->DeveloperUserEmail=htmlspecialchars(strip_tags($this->DeveloperUserEmail));
        $this->DeveloperId=htmlspecialchars(strip_tags($this->DeveloperId));
        $this->IsAdmin=htmlspecialchars(strip_tags($this->IsAdmin));

        // привязка значений 
        $stmt->bindParam(":DeveloperUserName", $this->DeveloperUserName);
        $stmt->bindParam(":DeveloperUserPass", $this->DeveloperUserPass);
        $stmt->bindParam(":DeveloperUserEmail", $this->DeveloperUserEmail);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        $stmt->bindParam(":IsAdmin", $this->IsAdmin);


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
                    DeveloperUserName=:DeveloperUserName,
                    DeveloperUserPass=:DeveloperUserPass,
                    DeveloperUserEmail=:DeveloperUserEmail,
                    DeveloperId=:DeveloperId
                    IsAdmin=:IsAdmin
                WHERE
                    DeveloperUserID = :DeveloperUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->DeveloperUserID=htmlspecialchars(strip_tags($this->DeveloperUserID));
        $this->DeveloperUserName=htmlspecialchars(strip_tags($this->DeveloperUserName));
        $this->DeveloperUserPass=htmlspecialchars(strip_tags($this->DeveloperUserPass));
        $this->DeveloperUserEmail=htmlspecialchars(strip_tags($this->DeveloperUserEmail));
        $this->IsAdmin=htmlspecialchars(strip_tags($this->IsAdmin));
        $this->DeveloperId=htmlspecialchars(strip_tags($this->DeveloperId));

        // привязка значений 
        $stmt->bindParam(":DeveloperUserID", $this->DeveloperUserID);
        $stmt->bindParam(":DeveloperUserName", $this->DeveloperUserName);
        $stmt->bindParam(":DeveloperUserPass", $this->DeveloperUserPass);
        $stmt->bindParam(":DeveloperUserEmail", $this->DeveloperUserEmail);
        $stmt->bindParam(":DeveloperId", $this->DeveloperId);
        $stmt->bindParam(":IsAdmin", $this->IsAdmin);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE DeveloperUserID =:DeveloperUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->DeveloperUserID=htmlspecialchars(strip_tags($this->DeveloperUserID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":DeveloperUserID", $this->DeveloperUserID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function generateGuardCode(){
        // генерация токена для входа через QR код
        $authkey = '';
        $symbolarray = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $flag = 0;
        // создаем код
        for($i = 0; $i < 6; $i++){
            $authkey = $authkey . $symbolarray[rand(0, strlen($symbolarray) - 1)];
        }
        return $authkey;
    }

    
    function updateGuardCode(){

        // запрос для обновления записи (товара) 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    DeveloperUserGuardCode =:DeveloperUserGuardCode
                WHERE
                  DeveloperUserID =:DeveloperUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->DeveloperUserGuardCode=htmlspecialchars(strip_tags($this->generateGuardCode()));
        // привязка значений 
        $stmt->bindParam(":DeveloperUserID", $this->DeveloperUserID);
        $stmt->bindParam(":DeveloperUserGuardCode", $this->DeveloperUserGuardCode);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>