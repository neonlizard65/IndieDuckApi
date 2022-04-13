<?php

class Developer{

    private $conn; //строка подключения
    private $table_name = 'Developer'; //таблица

    public $DeveloperID;
    public $DeveloperName;
    public $DeveloperLogo;
    public $DeveloperCard;
    public $DeveloperYoutube;
    public $DeveloperTwitch;
    public $DeveloperTwitter;
    public $DeveloperBio;
    public $CountryId;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getDevelopers(){
        $query = "SELECT * FROM " . $this->table_name;
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    }

    
    // разраб по индексу
    function getDeveloperByID(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE DeveloperID=:DeveloperID LIMIT 0,1";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":DeveloperID", $this->DeveloperID);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->DeveloperID = $row['DeveloperID'];
        $this->DeveloperName = $row['DeveloperName'];
        $this->DeveloperLogo = $row['DeveloperLogo'];
        $this->DeveloperCard = $row['DeveloperCard'];
        $this->DeveloperYoutube = $row['DeveloperYoutube'];
        $this->DeveloperTwitch = $row['DeveloperTwitch'];
        $this->DeveloperTwitter = $row['DeveloperTwitter'];
        $this->DeveloperBio = $row['DeveloperBio'];
        $this->CountryId = $row['CountryId'];
    }
    

      // разрабы по стране
      function getDeveloperByCountry(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE CountryId=:CountryId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":CountryId", $this->CountryId);
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
                    DeveloperName=:DeveloperName,
                    DeveloperLogo=:DeveloperLogo,
                    DeveloperCard=:DeveloperCard,
                    DeveloperYoutube=:DeveloperYoutube,
                    DeveloperTwitch=:DeveloperTwitch,
                    DeveloperTwitter=:DeveloperTwitter,
                    DeveloperBio=:DeveloperBio,
                    CountryId=:CountryId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->DeveloperName=htmlspecialchars(strip_tags($this->DeveloperName));
        $this->DeveloperLogo=htmlspecialchars(strip_tags($this->DeveloperLogo));
        $this->DeveloperCard=htmlspecialchars(strip_tags($this->DeveloperCard));
        $this->DeveloperYoutube=htmlspecialchars(strip_tags($this->DeveloperYoutube));
        $this->DeveloperTwitch=htmlspecialchars(strip_tags($this->DeveloperTwitch));
        $this->DeveloperTwitter=htmlspecialchars(strip_tags($this->DeveloperTwitter));
        $this->DeveloperBio=htmlspecialchars(strip_tags($this->DeveloperBio));
        $this->CountryId=htmlspecialchars(strip_tags($this->CountryId));

        // привязка значений 
        $stmt->bindParam(":DeveloperName", $this->DeveloperName);
        $stmt->bindParam(":DeveloperLogo", $this->DeveloperLogo);
        $stmt->bindParam(":DeveloperCard", $this->DeveloperCard);
        $stmt->bindParam(":DeveloperYoutube", $this->DeveloperYoutube);
        $stmt->bindParam(":DeveloperTwitch", $this->DeveloperTwitch);
        $stmt->bindParam(":DeveloperTwitter", $this->DeveloperTwitter);
        $stmt->bindParam(":DeveloperBio", $this->DeveloperBio);
        $stmt->bindParam(":CountryId", $this->CountryId);

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
                    DeveloperName=:DeveloperName,
                    DeveloperLogo=:DeveloperLogo,
                    DeveloperCard=:DeveloperCard,
                    DeveloperYoutube=:DeveloperYoutube,
                    DeveloperTwitch=:DeveloperTwitch,
                    DeveloperTwitter=:DeveloperTwitter,
                    DeveloperBio=:DeveloperBio,
                    CountryId=:CountryId
                WHERE
                    DeveloperID = :DeveloperID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->DeveloperID=htmlspecialchars(strip_tags($this->DeveloperID));
        $this->DeveloperName=htmlspecialchars(strip_tags($this->DeveloperName));
        $this->DeveloperLogo=htmlspecialchars(strip_tags($this->DeveloperLogo));
        $this->DeveloperCard=htmlspecialchars(strip_tags($this->DeveloperCard));
        $this->DeveloperYoutube=htmlspecialchars(strip_tags($this->DeveloperYoutube));
        $this->DeveloperTwitch=htmlspecialchars(strip_tags($this->DeveloperTwitch));
        $this->DeveloperTwitter=htmlspecialchars(strip_tags($this->DeveloperTwitter));
        $this->DeveloperBio=htmlspecialchars(strip_tags($this->DeveloperBio));
        $this->CountryId=htmlspecialchars(strip_tags($this->CountryId));

        // привязка значений 
        $stmt->bindParam(":DeveloperID", $this->DeveloperID);
        $stmt->bindParam(":DeveloperName", $this->DeveloperName);
        $stmt->bindParam(":DeveloperLogo", $this->DeveloperLogo);
        $stmt->bindParam(":DeveloperCard", $this->DeveloperCard);
        $stmt->bindParam(":DeveloperYoutube", $this->DeveloperYoutube);
        $stmt->bindParam(":DeveloperTwitch", $this->DeveloperTwitch);
        $stmt->bindParam(":DeveloperTwitter", $this->DeveloperTwitter);
        $stmt->bindParam(":DeveloperBio", $this->DeveloperBio);
        $stmt->bindParam(":CountryId", $this->CountryId);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE DeveloperID =:DeveloperID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->DeveloperID=htmlspecialchars(strip_tags($this->DeveloperID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":DeveloperID", $this->DeveloperID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>