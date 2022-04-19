<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/chatuser.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$chatuser = new ChatUser($db);
// чтение 
$chatuser->ChatId = isset($_GET["ChatId"]) ? $_GET["ChatId"] : die(); 

$stmt = $chatuser->getUsersFromChat();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $chatuser_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $chatuser_item=array(
            "ChatUserID" => $ChatUserID,
            "ChatId" => $ChatId,
            "UserId" => $UserId,
            "RoleId" => $RoleId
        );
        array_push($chatuser_arr, $chatuser_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($chatuser_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("chatuser" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>