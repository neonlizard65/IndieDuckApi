<?php

class User{

    private $conn; //строка подключения
    private $table_name = 'User'; //таблица

    //поля
    public $UserID;
    public $UserName;
    public $UserPassword;
    public $UserEmail;
    public $UserPhone;
    public $UserAuthToken;
    public $UserGuardCode;
    public $UserLevelId;
    public $LevelNumber;
    public $UserAvatar;
    public $UserXP;
    public $ProfileBackground;
    public $IsPrivate;
    public $StatusId;
    public $UserRealName;
    public $UserCountryId;
    public $Bio;
    public $EmailSubscription;
    public $LastOnline;
    public $ContentPrivacyTypeId;


    public function __construct($db) {
        //конструктор
        $this->conn = $db; 
    }

    //получить пользователя по логину
    function getUserByLogin(){
        //запрос
        $query = "SELECT u.UserID, u.UserName, u.UserPassword, u.UserEmail, u.UserPhone, u.UserAuthToken, u.UserGuardCode, u.UserLevelId, u.UserAvatar, u.UserXP, u.ProfileBackground, u.IsPrivate,
        u.StatusId, u.UserRealName, u.UserCountryId, u.Bio, u.EmailSubscription,
        u.LastOnline, u.ContentPrivacyTypeId FROM " . $this->table_name . " u
        WHERE u.UserName =:UserName";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // привязываем полученный логин с логинами из запроса
        $stmt->bindParam(":UserName", $this->UserName);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->UserID = $row['UserID'];
        $this->UserName = $row['UserName'];
        $this->UserPassword = $row['UserPassword'];
        $this->UserEmail = $row['UserEmail'];
        $this->UserPhone = $row['UserPhone'];
        $this->UserAuthToken = $row['UserAuthToken'];
        $this->UserGuardCode = $row['UserGuardCode'];
        $this->UserLevelId = $row['UserLevelId'];
        $this->UserAvatar = $row['UserAvatar'];
        $this->UserXP = $row['UserXP'];
        $this->ProfileBackground = $row['ProfileBackground'];
        $this->IsPrivate = $row['IsPrivate'];
        $this->StatusId = $row['StatusId'];
        $this->UserRealName = $row['UserRealName'];
        $this->UserCountryId = $row['UserCountryId'];
        $this->Bio = $row['Bio'];
        $this->EmailSubscription = $row['EmailSubscription'];
        $this->LastOnline = $row['LastOnline'];
        $this->ContentPrivacyTypeId = $row['ContentPrivacyTypeId'];
    }
    
    // логин по почте
    function getUserByEmail() {
        //запрос
        $query = "SELECT u.UserID, u.UserName, u.UserPassword, u.UserEmail, u.UserPhone, u.UserAuthToken, u.UserGuardCode, u.UserLevelId, u.UserAvatar, u.UserXP, u.ProfileBackground, u.IsPrivate,
        u.StatusId, u.UserRealName, u.UserCountryId, u.Bio, u.EmailSubscription,
        u.LastOnline, u.ContentPrivacyTypeId FROM " . $this->table_name . " u
        WHERE u.UserEmail =:UserEmail";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // привязываем полученную почту с почтами из запроса
        $stmt->bindParam(":UserEmail", $this->UserEmail);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->UserID = $row['UserID'];
        $this->UserName = $row['UserName'];
        $this->UserPassword = $row['UserPassword'];
        $this->UserEmail = $row['UserEmail'];
        $this->UserPhone = $row['UserPhone'];
        $this->UserAuthToken = $row['UserAuthToken'];
        $this->UserGuardCode = $row['UserGuardCode'];
        $this->UserLevelId = $row['UserLevelId'];
        $this->UserAvatar = $row['UserAvatar'];
        $this->UserXP = $row['UserXP'];
        $this->ProfileBackground = $row['ProfileBackground'];
        $this->IsPrivate = $row['IsPrivate'];
        $this->StatusId = $row['StatusId'];
        $this->UserRealName = $row['UserRealName'];
        $this->UserCountryId = $row['UserCountryId'];
        $this->Bio = $row['Bio'];
        $this->EmailSubscription = $row['EmailSubscription'];
        $this->LastOnline = $row['LastOnline'];
        $this->ContentPrivacyTypeId = $row['ContentPrivacyTypeId'];

    }

    // логин по телефону
    function getUserByPhone() {
        //запрос
        $query = "SELECT u.UserID, u.UserName, u.UserPassword, u.UserEmail, u.UserPhone, u.UserAuthToken, u.UserGuardCode, u.UserLevelId, u.UserAvatar, u.UserXP, u.ProfileBackground, u.IsPrivate,
        u.StatusId, u.UserRealName, u.UserCountryId, u.Bio, u.EmailSubscription,
        u.LastOnline, u.ContentPrivacyTypeId FROM " . $this->table_name . " u
        WHERE u.UserPhone =:UserPhone";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // привязываем полученный телефон с телефонами из запроса
        $stmt->bindParam(":UserPhone", $this->UserPhone);
        // выполняем запрос 
        $stmt->execute();
        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта 
        $this->UserID = $row['UserID'];
        $this->UserName = $row['UserName'];
        $this->UserPassword = $row['UserPassword'];
        $this->UserEmail = $row['UserEmail'];
        $this->UserPhone = $row['UserPhone'];
        $this->UserAuthToken = $row['UserAuthToken'];
        $this->UserGuardCode = $row['UserGuardCode'];
        $this->UserLevelId = $row['UserLevelId'];
        $this->UserAvatar = $row['UserAvatar'];
        $this->UserXP = $row['UserXP'];
        $this->ProfileBackground = $row['ProfileBackground'];
        $this->IsPrivate = $row['IsPrivate'];
        $this->StatusId = $row['StatusId'];
        $this->UserRealName = $row['UserRealName'];
        $this->UserCountryId = $row['UserCountryId'];
        $this->Bio = $row['Bio'];
        $this->EmailSubscription = $row['EmailSubscription'];
        $this->LastOnline = $row['LastOnline'];
        $this->ContentPrivacyTypeId = $row['ContentPrivacyTypeId'];

    }

    function getAllUsers() {
        //запрос
        $query = "SELECT u.UserID, u.UserName, u.UserPassword, u.UserEmail, u.UserPhone, u.UserAuthToken, u.UserGuardCode, u.UserLevelId, u.UserAvatar, u.UserXP, u.ProfileBackground, u.IsPrivate,
        u.StatusId, u.UserRealName, u.UserCountryId, u.Bio, u.EmailSubscription,
        u.LastOnline, u.ContentPrivacyTypeId  FROM " . $this->table_name . " u 
        ";
        // подготовка запроса s
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    } 

    
    function getUsersSearch($search) {
        //запрос
        $query = "SELECT u.UserID, u.UserName, u.UserPassword, u.UserEmail, u.UserPhone, u.UserAuthToken, u.UserGuardCode, u.UserLevelId, u.UserAvatar, u.UserXP, u.ProfileBackground, u.IsPrivate,
        u.StatusId, u.UserRealName, u.UserCountryId, u.Bio, u.EmailSubscription,
        u.LastOnline, u.ContentPrivacyTypeId FROM " . $this->table_name . " u 
         WHERE UPPER(u.UserName) LIKE UPPER('%" . $search . "%')";
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
        // выполняем запрос 
        $stmt->execute();
        return $stmt;
    } 


    function generateAuthKey(){
        // генерация токена для входа через QR код
        $authkey = '';
        $symbolarray = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $flag = 0;
        while($flag == 0){
            // создаем код
            $authkey = '';
            for($i = 0; $i < 50; $i++){
                $authkey = $authkey . $symbolarray[rand(0, strlen($symbolarray) - 1)];
            }
            $query = "SELECT COUNT(UserAuthToken) FROM " . $this->table_name . " WHERE UserAuthToken =:UserAuthToken";
            
            //проверяем если такой уже есть, если нет, выходим из цикла
            $stmt = $this->conn->prepare($query);
            // привязываем полученную почту с почтами из запроса
            $stmt->bindParam(":UserAuthToken", $authkey);
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
        return $authkey;
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

    // метод create - создание товаров 
    function create(){
        // запрос для вставки (создания) записей 
        $query = "INSERT INTO 
                    " . $this->table_name . " 
                SET
                    UserName =:UserName,
                    UserPassword =:UserPassword,
                    UserEmail =:UserEmail,
                    UserPhone =:UserPhone,
                    UserLevelId =:UserLevelId,
                    UserAuthToken =:UserAuthToken,
                    UserAvatar =:UserAvatar,
                    UserXP =:UserXP,
                    ProfileBackground =:ProfileBackground,
                    IsPrivate =:IsPrivate,
                    UserRealName =:UserRealName,
                    UserCountryId =:UserCountryId, 
                    Bio =:Bio,
                    EmailSubscription =:EmailSubscription,
                    ContentPrivacyTypeId =:ContentPrivacyTypeId";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserName=htmlspecialchars(strip_tags($this->UserName));
        $this->UserPassword=htmlspecialchars(strip_tags($this->UserPassword));
        $this->UserEmail=htmlspecialchars(strip_tags($this->UserEmail));
        $this->UserPhone=htmlspecialchars(strip_tags($this->UserPhone));
        $this->UserLevelId="1";
        $this->UserAvatar=htmlspecialchars(strip_tags($this->UserAvatar));
        $this->UserXP="0";
        $this->UserAuthToken=htmlspecialchars(strip_tags($this->generateAuthKey()));
        $this->ProfileBackground=htmlspecialchars(strip_tags($this->ProfileBackground));
        $this->IsPrivate=htmlspecialchars(strip_tags($this->IsPrivate));
        $this->UserRealName=htmlspecialchars(strip_tags($this->UserRealName));
        $this->UserCountryId=htmlspecialchars(strip_tags($this->UserCountryId));
        $this->Bio=htmlspecialchars(strip_tags($this->Bio));
        $this->EmailSubscription=htmlspecialchars(strip_tags($this->EmailSubscription));
        $this->ContentPrivacyTypeId=htmlspecialchars(strip_tags($this->ContentPrivacyTypeId));

        // привязка значений 
        $stmt->bindParam(":UserName", $this->UserName);
        $stmt->bindParam(":UserPassword", $this->UserPassword);
        $stmt->bindParam(":UserEmail", $this->UserEmail);
        $stmt->bindParam(":UserPhone", $this->UserPhone);
        $stmt->bindParam(":UserLevelId", $this->UserLevelId);
        $stmt->bindParam(":UserAuthToken", $this->UserAuthToken);
        $stmt->bindParam(":UserAvatar", $this->UserAvatar);
        $stmt->bindParam(":UserXP", $this->UserXP);
        $stmt->bindParam(":ProfileBackground", $this->ProfileBackground);
        $stmt->bindParam(":IsPrivate", $this->IsPrivate);
        $stmt->bindParam(":UserRealName", $this->UserRealName);
        $stmt->bindParam(":UserCountryId", $this->UserCountryId);
        $stmt->bindParam(":Bio", $this->Bio);
        $stmt->bindParam(":EmailSubscription", $this->EmailSubscription);
        $stmt->bindParam(":ContentPrivacyTypeId", $this->ContentPrivacyTypeId);   

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
            
    // метод update() - обновление товара 
    function update(){

        // запрос для обновления записи (товара) 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                  UserName =:UserName,
                  UserPassword =:UserPassword,
                  UserEmail =:UserEmail,
                  UserPhone =:UserPhone,
                  UserLevelId =:UserLevelId,
                  UserAvatar =:UserAvatar,
                  UserXP =:UserXP,
                  ProfileBackground =:ProfileBackground,
                  IsPrivate =:IsPrivate,
                  StatusId =:StatusId,
                  UserRealName =:UserRealName,
                  UserCountryId =:UserCountryId, 
                  Bio =:Bio,
                  EmailSubscription =:EmailSubscription,
                  LastOnline =:LastOnline,
                  ContentPrivacyTypeId =:ContentPrivacyTypeId
                WHERE
                  UserID = :UserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserID=htmlspecialchars(strip_tags($this->UserID));
        $this->UserName=htmlspecialchars(strip_tags($this->UserName));
        $this->UserPassword=htmlspecialchars(strip_tags($this->UserPassword));
        $this->UserEmail=htmlspecialchars(strip_tags($this->UserEmail));
        $this->UserPhone=htmlspecialchars(strip_tags($this->UserPhone));
        $this->UserLevelId=htmlspecialchars(strip_tags($this->UserLevelId));
        $this->UserAvatar=htmlspecialchars(strip_tags($this->UserAvatar));
        $this->UserXP=htmlspecialchars(strip_tags($this->UserXP));
        $this->ProfileBackground=htmlspecialchars(strip_tags($this->ProfileBackground));
        $this->IsPrivate=htmlspecialchars(strip_tags($this->IsPrivate));
        $this->StatusId=htmlspecialchars(strip_tags($this->StatusId));
        $this->UserRealName=htmlspecialchars(strip_tags($this->UserRealName));
        $this->UserCountryId=htmlspecialchars(strip_tags($this->UserCountryId));
        $this->Bio=htmlspecialchars(strip_tags($this->Bio));
        $this->EmailSubscription=htmlspecialchars(strip_tags($this->EmailSubscription));
        $this->LastOnline=htmlspecialchars(strip_tags($this->LastOnline));
        $this->ContentPrivacyTypeId=htmlspecialchars(strip_tags($this->ContentPrivacyTypeId));

        // привязка значений 
        $stmt->bindParam(":UserID", $this->UserID);
        $stmt->bindParam(":UserName", $this->UserName);
        $stmt->bindParam(":UserPassword", $this->UserPassword);
        $stmt->bindParam(":UserEmail", $this->UserEmail);
        $stmt->bindParam(":UserPhone", $this->UserPhone);
        $stmt->bindParam(":UserLevelId", $this->UserLevelId);
        $stmt->bindParam(":UserAvatar", $this->UserAvatar);
        $stmt->bindParam(":UserXP", $this->UserXP);
        $stmt->bindParam(":ProfileBackground", $this->ProfileBackground);
        $stmt->bindParam(":IsPrivate", $this->IsPrivate);
        $stmt->bindParam(":StatusId", $this->StatusId);
        $stmt->bindParam(":UserRealName", $this->UserRealName);
        $stmt->bindParam(":UserCountryId", $this->UserCountryId);
        $stmt->bindParam(":Bio", $this->Bio);
        $stmt->bindParam(":EmailSubscription", $this->EmailSubscription);
        $stmt->bindParam(":LastOnline", $this->LastOnline);
        $stmt->bindParam(":ContentPrivacyTypeId", $this->ContentPrivacyTypeId);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // метод delete - удаление пользователя
    function delete(){
    
        // запрос для удаления записи (товара) 
        $query = "DELETE FROM " . $this->table_name . " WHERE UserID=:UserID";
    
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
    
        // очистка 
        $this->UserID=htmlspecialchars(strip_tags($this->UserID));
        
        // привязываем id записи для удаления 
        $stmt->bindParam(":UserID", $this->UserID);
    
        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }

    function updateAuthKey(){

        // запрос для обновления записи (товара) 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                  UserAuthToken =:UserAuthToken
                WHERE
                  UserID =:UserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserAuthToken=htmlspecialchars(strip_tags($this->generateAuthKey()));
        // привязка значений 
        $stmt->bindParam(":UserID", $this->UserID);
        $stmt->bindParam(":UserAuthToken", $this->UserAuthToken);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function updateGuardCode(){

        // запрос для обновления записи (товара) 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                  UserGuardCode =:UserGuardCode
                WHERE
                  UserID =:UserID";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очисткa
        $this->UserGuardCode=htmlspecialchars(strip_tags($this->generateGuardCode()));
        // привязка значений 
        $stmt->bindParam(":UserID", $this->UserID);
        $stmt->bindParam(":UserGuardCode", $this->UserGuardCode);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>