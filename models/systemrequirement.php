<?php

class SystemRequirement{

    private $conn; //строка подключения
    private $table_name = 'SystemRequirement'; //таблица

    public $SystemRequirementID; 
    public $ProductId;
    public $PlatformId;
    public $Name;
    public $IsMinimumRecommended;
    public $OS;
    public $CPU;
    public $RAM;
    public $GPU;
    public $DirectX;
    public $Storage;
    public $SoundCard;
    public $Network;
    public $AdditionalNotes;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getSysReq(){
        $query = "SELECT sr.SystemRequirementID, sr.ProductId, sr.PlatformId, p.Name, sr.IsMinimumRecommended, sr.OS, sr.CPU,
        sr.RAM, sr.GPU, sr.DirectX, sr.Storage, sr.SoundCard, sr.Network, sr.AdditionalNotes FROM " . $this->table_name . " sr 
        INNER JOIN Platform p ON sr.PlatformId = p.PlatformID WHERE sr.ProductId =:ProductId";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ProductId", $this->ProductId);
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
                    ProductId=:ProductId,
                    PlatformId=:PlatformId,
                    IsMinimumRecommended=:IsMinimumRecommended,
                    OS =:OS,
                    CPU =:CPU,
                    RAM =:RAM,
                    GPU =:GPU,
                    DirectX =:DirectX,
                    Storage =:Storage,
                    SoundCard =:SoundCard,
                    Network =:Network,
                    AdditionalNotes =:AdditionalNotes";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->PlatformId=htmlspecialchars(strip_tags($this->PlatformId));
         $this->OS=htmlspecialchars(strip_tags($this->OS));
        $this->CPU=htmlspecialchars(strip_tags($this->CPU));
        $this->RAM=htmlspecialchars(strip_tags($this->RAM));
        $this->GPU=htmlspecialchars(strip_tags($this->GPU));
        $this->DirectX=htmlspecialchars(strip_tags($this->DirectX));
        $this->Storage=htmlspecialchars(strip_tags($this->Storage));
        $this->SoundCard=htmlspecialchars(strip_tags($this->SoundCard));
        $this->Network=htmlspecialchars(strip_tags($this->Network));
        $this->AdditionalNotes=htmlspecialchars(strip_tags($this->AdditionalNotes));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":PlatformId", $this->PlatformId);
        $stmt->bindParam(":IsMinimumRecommended", $this->IsMinimumRecommended);
        $stmt->bindParam(":OS", $this->OS);
        $stmt->bindParam(":CPU", $this->CPU);
        $stmt->bindParam(":RAM", $this->RAM);
        $stmt->bindParam(":GPU", $this->GPU);
        $stmt->bindParam(":DirectX", $this->DirectX);
        $stmt->bindParam(":Storage", $this->Storage);
        $stmt->bindParam(":SoundCard", $this->SoundCard);
        $stmt->bindParam(":Network", $this->Network);
        $stmt->bindParam(":AdditionalNotes", $this->AdditionalNotes);

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
                    ProductId=:ProductId,
                    PlatformId=:PlatformId,
                    IsMinimumRecommended=:IsMinimumRecommended,
                    OS =:OS,
                    CPU =:CPU,
                    RAM =:RAM,
                    GPU =:GPU,
                    DirectX =:DirectX,
                    Storage =:Storage,
                    SoundCard =:SoundCard,
                    Network =:Network,
                    AdditionalNotes =:AdditionalNotes
                WHERE
                  SystemRequirementID = :SystemRequirementID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->SystemRequirementID=htmlspecialchars(strip_tags($this->SystemRequirementID));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->PlatformId=htmlspecialchars(strip_tags($this->PlatformId));
       $this->OS=htmlspecialchars(strip_tags($this->OS));
        $this->CPU=htmlspecialchars(strip_tags($this->CPU));
        $this->RAM=htmlspecialchars(strip_tags($this->RAM));
        $this->GPU=htmlspecialchars(strip_tags($this->GPU));
        $this->DirectX=htmlspecialchars(strip_tags($this->DirectX));
        $this->Storage=htmlspecialchars(strip_tags($this->Storage));
        $this->SoundCard=htmlspecialchars(strip_tags($this->SoundCard));
        $this->Network=htmlspecialchars(strip_tags($this->Network));
        $this->AdditionalNotes=htmlspecialchars(strip_tags($this->AdditionalNotes));

        // привязка значений 
        $stmt->bindParam(":SystemRequirementID", $this->SystemRequirementID);
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":PlatformId", $this->PlatformId);
        $stmt->bindParam(":IsMinimumRecommended", $this->IsMinimumRecommended);
        $stmt->bindParam(":OS", $this->OS);
        $stmt->bindParam(":CPU", $this->CPU);
        $stmt->bindParam(":RAM", $this->RAM);
        $stmt->bindParam(":GPU", $this->GPU);
        $stmt->bindParam(":DirectX", $this->DirectX);
        $stmt->bindParam(":Storage", $this->Storage);
        $stmt->bindParam(":SoundCard", $this->SoundCard);
        $stmt->bindParam(":Network", $this->Network);
        $stmt->bindParam(":AdditionalNotes", $this->AdditionalNotes);


        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // метод delete - удаление группы 
    function delete(){
    
        // запрос для удаления записи (группы) 
        $query = "DELETE FROM " . $this->table_name . " WHERE SystemRequirementID =:SystemRequirementID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->SystemRequirementID=htmlspecialchars(strip_tags($this->SystemRequirementID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":SystemRequirementID", $this->SystemRequirementID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
?>