<?php

class CDKey{

    private $conn; //строка подключения
    private $table_name = 'CDKey'; //таблица

    public $CDKeyID;
    public $Content;
    public $ProductId;
    public $IsRedeemed;

    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    // все группы
    function getCDKeysByProduct(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE ProductId=:ProductId";
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
                    Content=:Content,
                    ProductId=:ProductId,
                    IsRedeemed=0";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->Content=htmlspecialchars(strip_tags($this->generateAuthKey()));
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        // привязка значений 
        $stmt->bindParam(":Content", $this->Content);
        $stmt->bindParam(":ProductId", $this->ProductId);
        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function update(){
        // запрос для вставки (создания) записей 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                   ProductId=:ProductId,
                   IsRedeemed=:IsRedeemed
                WHERE
                    CDKeyID = :CDKeyID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->ProductId=htmlspecialchars(strip_tags($this->ProductId));
        $this->CDKeyID=htmlspecialchars(strip_tags($this->CDKeyID));

        // привязка значений 
        $stmt->bindParam(":ProductId", $this->ProductId);
        $stmt->bindParam(":IsRedeemed", $this->IsRedeemed);
        $stmt->bindParam(":CDKeyID", $this->CDKeyID);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    function generateAuthKey(){
        // генерация токена для входа через QR код
        $cdkey = '';
        $symbolarray = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $flag = 0;
        while($flag == 0){
            // создаем код
            $cdkey = '';
            for($i = 0; $i < 20; $i++){
                $cdkey = $cdkey . $symbolarray[rand(0, strlen($symbolarray) - 1)];
            }
            $query = "SELECT COUNT(Content) FROM " . $this->table_name . " WHERE Content =:Content";
            
            //проверяем если такой уже есть, если нет, выходим из цикла
            $stmt = $this->conn->prepare($query);
            // привязываем полученную почту с почтами из запроса
            $stmt->bindParam(":Content", $cdkey);
            // выполняем запрос 
            $stmt->execute();
            // получаем извлеченную строку 
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // подключение базы данных и файл, содержащий объекты 
    
            $count = 0;
            foreach ($stmt as $row) {
                $count = $row[0];
            };

            if($count == 0){
                $flag = 1;
            }
        }
        return $cdkey;
    }

}
?>