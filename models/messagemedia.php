<?php
class MessageMedia{

    private $conn; //строка подключения
    private $table_name = 'MessageMedia'; //таблица

    //MessageMedia
    public $MessageMediaID;
    public $MessageId;
    public $Media;

    public function __construct($db) {
        $this->conn = $db; 
    }

    //Выборка медиа по сообщению
    function getMessageMedia(){
        $query = "SELECT * FROM MessageMedia WHERE MessageId =:MessageId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam("MessageId", $this->MessageId);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    //Выборка медиа по чату
    function getMediaByChat($chatId){
        $query = "SELECT * FROM MessageMedia mm INNER JOIN Message m ON mm.MessageId = m.MessageID INNER JOIN Chat c ON m.ChatId = c.ChatID WHERE m.ChatId =:ChatId";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        echo $chatId;
        $stmt->bindParam(":ChatId", $chatId);
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
                        MessageId=:MessageId,
                        Media=:Media";
    
            // подготовка запроса 
            $stmt = $this->conn->prepare($query);
    
            // очисткa
            $this->MessageId=htmlspecialchars(strip_tags($this->MessageId));
            $this->Media=htmlspecialchars(strip_tags($this->Media));
    
            // привязка значений 
            $stmt->bindParam(":MessageId", $this->MessageId);
            $stmt->bindParam(":Media", $this->Media);
    
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
                        MessageId=:MessageId,
                        Media=:Media
                    WHERE
                        MessageMediaID = :MessageMediaID";
    
            // подготовка запроса 
            $stmt = $this->conn->prepare($query);
    
            // очисткa
            $this->MessageId=htmlspecialchars(strip_tags($this->MessageId));
            $this->Media=htmlspecialchars(strip_tags($this->Media));
            $this->MessageMediaID=htmlspecialchars(strip_tags($this->MessageMediaID));

            // привязка значений 
            $stmt->bindParam(":MessageId", $this->MessageId);
            $stmt->bindParam(":Media", $this->Media);
            $stmt->bindParam(":MessageMediaID", $this->MessageMediaID);
    
    
            // выполняем запрос 
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    
        
        // метод delete - удаление 
        function delete(){
        
            // запрос для удаления записи 
            $query = "DELETE FROM " . $this->table_name . " WHERE MessageMediaID =:MessageMediaID";
    
            // подготовка запроса 
            $stmt = $this->conn->prepare($query);
    
            // очистка 
            $this->MessageMediaID=htmlspecialchars(strip_tags($this->MessageMediaID));
            
            // привязываем id записи для удаления 
            $stmt->bindParam(":MessageMediaID", $this->MessageMediaID);
    
            // выполняем запрос 
            if ($stmt->execute()) {
                return true;
            }
    
            return false;
        }
}