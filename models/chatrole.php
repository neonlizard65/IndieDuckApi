<?php
class ChatRole{
    private $conn; //строка подключения
    private $table_name = 'ChatRole'; //таблица

    public $ChatRoleID;
    public $ChatId;
    public $RoleName;
    public $WritePrivelege;
    public $ModPrivelege;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getRolesFromChat(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ChatId =:ChatId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ChatId", $this->ChatId);

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
                    ChatId=:ChatId,
                    RoleName=:RoleName,
                    WritePrivelege=:WritePrivelege,
                    ModPrivelege=:ModPrivelege";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ChatId=htmlspecialchars(strip_tags($this->ChatId));
        $this->RoleName=htmlspecialchars(strip_tags($this->RoleName));
        $this->WritePrivelege=htmlspecialchars(strip_tags($this->WritePrivelege));
        $this->ModPrivelege=htmlspecialchars(strip_tags($this->ModPrivelege));

        // привязка значений 
        $stmt->bindParam(":ChatId", $this->ChatId);
        $stmt->bindParam(":RoleName", $this->RoleName);
        $stmt->bindParam(":WritePrivelege", $this->WritePrivelege);
        $stmt->bindParam(":ModPrivelege", $this->ModPrivelege);

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
                    ChatId=:ChatId,
                    RoleName=:RoleName,
                    WritePrivelege=:WritePrivelege,
                    ModPrivelege=:ModPrivelege
                WHERE
                    ChatRoleID = :ChatRoleID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ChatId=htmlspecialchars(strip_tags($this->ChatId));
        $this->RoleName=htmlspecialchars(strip_tags($this->RoleName));
        $this->WritePrivelege=htmlspecialchars(strip_tags($this->WritePrivelege));
        $this->ModPrivelege=htmlspecialchars(strip_tags($this->ModPrivelege));
        $this->ChatRoleID=htmlspecialchars(strip_tags($this->ChatRoleID));

        // привязка значений 
        $stmt->bindParam(":ChatId", $this->ChatId);
        $stmt->bindParam(":RoleName", $this->RoleName);
        $stmt->bindParam(":WritePrivelege", $this->WritePrivelege);
        $stmt->bindParam(":ModPrivelege", $this->ModPrivelege);
        $stmt->bindParam(":ChatRoleID", $this->ChatRoleID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE ChatRoleID =:ChatRoleID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ChatRoleID=htmlspecialchars(strip_tags($this->ChatRoleID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ChatRoleID", $this->ChatRoleID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>