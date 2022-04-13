<?php
class Track{
    private $conn; //строка подключения
    private $table_name = 'Track'; //таблица

    public $TrackID;
    public $OSTId;
    public $DiscNumber;
    public $TrackNumber;
    public $SongName;
    public $Duration;

    public function __construct($db) {
        $this->conn = $db; 
    }

    function getTrackByOST(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE OSTId =:OSTId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":OSTId", $this->OSTId);

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
                    OSTId=:OSTId,
                    DiscNumber=:DiscNumber,
                    TrackNumber=:TrackNumber,
                    SongName =:SongName,
                    Duration=:Duration";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->OSTId=htmlspecialchars(strip_tags($this->OSTId));
        $this->DiscNumber=htmlspecialchars(strip_tags($this->DiscNumber));
        $this->TrackNumber=htmlspecialchars(strip_tags($this->TrackNumber));
        $this->SongName=htmlspecialchars(strip_tags($this->SongName));
        $this->Duration=htmlspecialchars(strip_tags($this->Duration));

        // привязка значений 
        $stmt->bindParam(":OSTId", $this->OSTId);
        $stmt->bindParam(":DiscNumber", $this->DiscNumber);
        $stmt->bindParam(":TrackNumber", $this->TrackNumber);
        $stmt->bindParam(":SongName", $this->SongName);
        $stmt->bindParam(":Duration", $this->Duration);
    
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
                    OSTId=:OSTId,
                    DiscNumber=:DiscNumber,
                    TrackNumber=:TrackNumber,
                    SongName =:SongName,
                    Duration=:Duration
                WHERE
                    TrackID = :TrackID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->TrackID=htmlspecialchars(strip_tags($this->TrackID));
        $this->OSTId=htmlspecialchars(strip_tags($this->OSTId));
        $this->DiscNumber=htmlspecialchars(strip_tags($this->DiscNumber));
        $this->TrackNumber=htmlspecialchars(strip_tags($this->TrackNumber));
        $this->SongName=htmlspecialchars(strip_tags($this->SongName));
        $this->Duration=htmlspecialchars(strip_tags($this->Duration));

        // привязка значений 
        $stmt->bindParam(":TrackID", $this->TrackID);
        $stmt->bindParam(":OSTId", $this->OSTId);
        $stmt->bindParam(":DiscNumber", $this->DiscNumber);
        $stmt->bindParam(":TrackNumber", $this->TrackNumber);
        $stmt->bindParam(":SongName", $this->SongName);
        $stmt->bindParam(":Duration", $this->Duration);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    // метод delete - удаление 
    function delete(){
    
        // запрос для удаления записи 
        $query = "DELETE FROM " . $this->table_name . " WHERE TrackID =:TrackID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->TrackID=htmlspecialchars(strip_tags($this->TrackID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":TrackID", $this->TrackID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}

?>