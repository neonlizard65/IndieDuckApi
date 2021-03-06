<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/user.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$user = new User($db);
// чтение монитора
$search = isset($_GET['Search']) ? $_GET['Search'] : die();
$stmt = $user->getUsersSearch($search);
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $user_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $user_item=array(
            "UserID" => $UserID,
            "UserName" => $UserName,
            "UserPassword" => $UserPassword,
            "UserEmail" => $UserEmail,
            "UserPhone" => $UserPhone,
            "UserAuthToken" => $UserAuthToken,
            "UserGuardCode" => $UserGuardCode,
            "UserLevelId" => $UserLevelId,
            "UserAvatar" => $UserAvatar,
            "UserXP" => $UserXP,
            "ProfileBackground" => $ProfileBackground,
            "IsPrivate" => $IsPrivate,
            "StatusId" => $StatusId,
            "UserRealName" => $UserRealName,
            "UserCountryId" => $UserCountryId,
            "Bio" => $Bio,
            "EmailSubscription" => $EmailSubscription,
            "LastOnline" => $LastOnline,
            "ContentPrivacyTypeId" => $ContentPrivacyTypeId
        );
        array_push($user_arr, $user_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($user_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}
?>