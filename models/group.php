<?php

class Group{

    private $conn; //строка подключения
    private $table_name = 'indieduck.Group'; //таблица

    public $GroupID;
    public $GroupName;
    public $GroupImage;
    public $GroupBio;
    public $RolePostPrivelege;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getAllGroups(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    // поиск группы
    function getGroupsLike($request){
        $query = "SELECT * FROM " . $this->table_name . " WHERE UPPER(GroupName) LIKE UPPER('%" . $request . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    // поиск группы по ID
    function getGroupByID(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE GroupID=:GroupID  LIMIT 0,1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":GroupID", $this->GroupID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->GroupID = $row['GroupID'];
        $this->GroupName = $row['GroupName'];
        $this->GroupImage = $row['GroupImage'];
        $this->GroupBio = $row['GroupBio'];
        $this->RolePostPrivelege = $row['RolePostPrivelege'];
    }

     // метод create - создание групп
     function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    GroupName=:GroupName,
                    GroupImage=:GroupImage,
                    GroupBio=:GroupBio,
                    RolePostPrivelege=:RolePostPrivelege";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->GroupName=htmlspecialchars(strip_tags($this->GroupName));
        $this->GroupImage=htmlspecialchars(strip_tags($this->GroupImage));
        $this->GroupBio=htmlspecialchars(strip_tags($this->GroupBio));
        $this->RolePostPrivelege=htmlspecialchars(strip_tags($this->RolePostPrivelege));

        // привязка значений 
        $stmt->bindParam(":GroupName", $this->GroupName);
        $stmt->bindParam(":GroupImage", $this->GroupImage);
        $stmt->bindParam(":GroupBio", $this->GroupBio);
        $stmt->bindParam(":RolePostPrivelege", $this->RolePostPrivelege);


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
                    GroupName=:GroupName,
                    GroupImage=:GroupImage,
                    GroupBio=:GroupBio,
                    RolePostPrivelege=:RolePostPrivelege
                WHERE
                    GroupID = :GroupID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->GroupID=htmlspecialchars(strip_tags($this->GroupID));
        $this->GroupName=htmlspecialchars(strip_tags($this->GroupName));
        $this->GroupImage=htmlspecialchars(strip_tags($this->GroupImage));
        $this->GroupBio=htmlspecialchars(strip_tags($this->GroupBio));
        $this->RolePostPrivelege=htmlspecialchars(strip_tags($this->RolePostPrivelege));



        // привязка значений 
        $stmt->bindParam(":GroupID", $this->GroupID);
        $stmt->bindParam(":GroupName", $this->GroupName);
        $stmt->bindParam(":GroupImage", $this->GroupImage);
        $stmt->bindParam(":GroupBio", $this->GroupBio);
        $stmt->bindParam(":RolePostPrivelege", $this->RolePostPrivelege);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE GroupID =:GroupID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->GroupID=htmlspecialchars(strip_tags($this->GroupID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":GroupID", $this->GroupID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>