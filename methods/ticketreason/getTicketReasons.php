<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/ticketreason.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$ticketreason = new TicketReason($db);
// чтение монитора
$stmt = $ticketreason->getTicketReasons();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $ticketreason_arr=array();
    $ticketreason_arr["ticketreasons"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $ticketreason_item=array(
            "TicketReasonID" => $TicketReasonID,
            "Name" => $Name
        );
        array_push($ticketreason_arr["ticketreasons"], $ticketreason_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($ticketreason_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Причины не найдены."), JSON_UNESCAPED_UNICODE);
}
?>