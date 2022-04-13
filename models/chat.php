<?php
class Chat{
    private $conn; //строка подключения
    private $table_name = 'Chat'; //таблица

    public $ChatID;
    public $ChatName;
    public $IsPrivateChat;
    public $GroupId;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getAllChats(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    function getGroupChatByID(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE GroupId =:GroupId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":GroupId", $this->GroupId);

        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->ChatID = $row['ChatID'];
        $this->ChatName = $row['ChatName'];
        $this->IsPrivateChat = $row['IsPrivateChat'];
        $this->GroupId = $row['GroupId'];
    }

    function getDMChat($user1id, $user2id){
        $query = "SELECT * FROM " . $this->table_name . " c INNER JOIN ChatUser cu ON c.ChatID = cu.ChatId WHERE c.IsPrivateChat = 1 AND (cu.UserId =:user1 OR cu.UserId =:user2)";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("user1", $user1id);
        $stmt->bindParam("user2", $user2id);

        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->ChatID = $row['ChatID'];
        $this->ChatName = $row['ChatName'];
        $this->IsPrivateChat = $row['IsPrivateChat'];
        $this->GroupId = $row['GroupId'];
    }
    
    function getChatByID(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ChatID =:ChatID";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ChatID", $this->ChatID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->ChatID = $row['ChatID'];
        $this->ChatName = $row['ChatName'];
        $this->IsPrivateChat = $row['IsPrivateChat'];
        $this->GroupId = $row['GroupId'];
    }

       // метод create - создание
       function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    ChatName=:ChatName,
                    GroupId=:GroupId,
                    IsPrivateChat=:IsPrivateChat";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ChatName=htmlspecialchars(strip_tags($this->ChatName));
      
        // привязка значений 
        $stmt->bindParam(":ChatName", $this->ChatName);
        $stmt->bindParam(":GroupId", $this->GroupId);
        $stmt->bindParam(":IsPrivateChat", $this->IsPrivateChat);

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
                    ChatName=:ChatName,
                    GroupId=:GroupId,
                    IsPrivateChat=:IsPrivateChat
                WHERE
                    ChatID = :ChatID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ChatID=htmlspecialchars(strip_tags($this->ChatID));
        $this->ChatName=htmlspecialchars(strip_tags($this->ChatName));
        $this->GroupId=htmlspecialchars(strip_tags($this->GroupId));
        $this->IsPrivateChat=htmlspecialchars(strip_tags($this->IsPrivateChat));

        // привязка значений 
        $stmt->bindParam(":ChatID", $this->ChatID);
        $stmt->bindParam(":ChatName", $this->ChatName);
        $stmt->bindParam(":GroupId", $this->GroupId);
        $stmt->bindParam(":IsPrivateChat", $this->IsPrivateChat);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE ChatID =:ChatID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->ChatID=htmlspecialchars(strip_tags($this->ChatID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":ChatID", $this->ChatID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}

?>