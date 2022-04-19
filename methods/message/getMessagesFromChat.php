<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/message.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$message = new Message($db);
// чтение 
$message->ChatId = isset($_GET["ChatId"]) ? $_GET["ChatId"] : die(); 

$stmt = $message->getMessagesFromChat();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $message_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $message_item=array(
            "MessageID" => $MessageID,
            "TextContent" => $TextContent,
            "UserId" => $UserId,
            "ChatId" => $ChatId,
            "Date" => $Date
        );
        array_push($message_arr, $message_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($message_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>