<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/messagemedia.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$messagemedia = new MessageMedia($db);
// чтение 
$chatId = isset($_GET["ChatId"]) ? $_GET["ChatId"] : die(); 

$stmt = $messagemedia->getMediaByChat($chatId);
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $messagemedia_arr=array();
    $messagemedia_arr["messagemedia"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $messagemedia_item=array(
            "MessageMediaID" => $MessageMediaID,
            "MessageId" => $MessageId,
            "Media" => $Media
        );
        array_push($messagemedia_arr["messagemedia"], $messagemedia_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($messagemedia_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("messagemedia" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>