<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/ticketmessagemedia.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$ticketmessagemedia = new TicketMessageMedia($db);
// чтение 
$ticketmessagemedia->TicketMessageId = isset($_GET["TicketMessageId"]) ? $_GET["TicketMessageId"] : die(); 

$stmt = $ticketmessagemedia->getMessagesByTicket();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $ticketmessagemedia_arr=array();
    $ticketmessagemedia_arr["ticketmessagemedia"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $ticketmessagemedia_item=array(
            "TicketMessageMediaID" => $TicketMessageMediaID,
            "TicketMessageId" => $TicketMessageId,
            "Media" => $Media
        );
        array_push($ticketmessagemedia_arr["ticketmessagemedia"], $ticketmessagemedia_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($ticketmessagemedia_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("ticketmessagemedia" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>