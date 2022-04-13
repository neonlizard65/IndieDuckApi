<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/user.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$user = new User($db);

// установим свойство ID записи для чтения 
$user->UserEmail = isset($_GET['UserEmail']) ? $_GET['UserEmail'] : die();

// прочитаем детали разраба для редактирования 
$user->getUserByEmail();

// если есть ID
if ($user->UserID != null) {

    // создание массива 
    $user_arr = array(
        "UserID" => $user->UserID,
        "UserName" => $user->UserName,
        "UserPassword" => $user->UserPassword,
        "UserEmail" => $user->UserEmail,
        "UserPhone" => $user->UserPhone,
        "UserAuthToken" => $user->UserAuthToken,
        "UserGuardCode" => $user->UserGuardCode,
        "UserLevelId" => $user->UserLevelId,
        "LevelNumber" => $user->LevelNumber,
        "UserAvatar" => $user->UserAvatar,
        "UserXP" => $user->UserXP,
        "ProfileBackground" => $user->ProfileBackground,
        "IsPrivate" => $user->IsPrivate,
        "StatusId" => $user->StatusId,
        "StatusName" => $user->StatusName,
        "StatusIcon" => $user->StatusIcon,
        "StatusColor" => $user->StatusColor,
        "UserRealName" => $user->UserRealName,
        "UserCountryId" => $user->UserCountryId,
        "CountryName" => $user->CountryName,
        "CountryCode" => $user->CountryCode,
        "CountryFlagImage" => $user->CountryFlagImage,
        "Bio" => $user->Bio,
        "EmailSubscription" => $user->EmailSubscription,
        "LastOnline" => $user->LastOnline,
        "ContentPrivacyTypeId" => $user->ContentPrivacyTypeId,
        "Name" => $user->PrivacyTypeName
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($user_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>