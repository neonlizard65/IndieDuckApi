<?php

class SpecialUser{

    private $conn; //строка подключения
    private $table_name = 'SpecialUser'; //таблица

    public $SpecialUserID;
    public $Login;
    public $Pass;
    public $RoleId;
    public $RoleName;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getSpecialUsers(){
        $query = "SELECT su.SpecialUserID, su.Login, su.Pass, su.RoleId, r.RoleName FROM " . $this->table_name . " su INNER JOIN Role r ON su.RoleId = r.RoleID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос  
        $stmt->execute();
        return $stmt;
    }

    function getSpecialUserByLogin(){
        $query = "SELECT su.SpecialUserID, su.Login, su.Pass, su.RoleId, r.RoleName FROM " . $this->table_name . " su INNER JOIN Role r ON su.RoleId = r.RoleID LIMIT 0,1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос  
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->SpecialUserID = $row['SpecialUserID'];
        $this->Login = $row['Login'];
        $this->Pass = $row['Pass'];
        $this->RoleName = $row['RoleName'];
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    Login=:Login,
                    Pass=:Pass,
                    RoleId=:RoleId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->Login=htmlspecialchars(strip_tags($this->Login));
        $this->Pass=htmlspecialchars(strip_tags($this->Pass));
        $this->RoleId=htmlspecialchars(strip_tags($this->RoleId));

        // привязка значений 
        $stmt->bindParam(":Login", $this->Login);
        $stmt->bindParam(":Pass", $this->Pass);
        $stmt->bindParam(":RoleId", $this->RoleId);

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
                    Login=:Login,
                    Pass=:Pass,
                    RoleId=:RoleId
                WHERE
                    SpecialUserID = :SpecialUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->SpecialUserID=htmlspecialchars(strip_tags($this->SpecialUserID));
        $this->Login=htmlspecialchars(strip_tags($this->Login));
        $this->Pass=htmlspecialchars(strip_tags($this->Pass));
        $this->RoleId=htmlspecialchars(strip_tags($this->RoleId));

        // привязка значений 
        $stmt->bindParam(":SpecialUserID", $this->SpecialUserID);
        $stmt->bindParam(":Login", $this->Login);
        $stmt->bindParam(":Pass", $this->Pass);
        $stmt->bindParam(":RoleId", $this->RoleId);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE SpecialUserID =:SpecialUserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->SpecialUserID=htmlspecialchars(strip_tags($this->SpecialUserID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":SpecialUserID", $this->SpecialUserID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>