<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/userfriend.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$userfriend = new UserFriend($db);
// чтение 
$userfriend->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $userfriend->getBlockedUsersByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $userfriend_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $userfriend_item=array(
            "UserFriendID" => $UserFriendID,
            "UserId" => $UserId,
            "FriendId" => $FriendId,
            "IsSent" => $IsSent,
            "IsAccepted" => $IsAccepted,
            "IsBlocked" => $IsBlocked
        );
        array_push($userfriend_arr, $userfriend_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($userfriend_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("userfriend" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>