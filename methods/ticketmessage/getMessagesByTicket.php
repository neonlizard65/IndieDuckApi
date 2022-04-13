<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/ticketmessage.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$ticketmessage = new TicketMessage($db);
// чтение 
$ticketmessage->TicketId = isset($_GET["TicketId"]) ? $_GET["TicketId"] : die(); 

$stmt = $ticketmessage->getMessagesByTicket();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $ticketmessage_arr=array();
    $ticketmessage_arr["ticketmessages"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $ticketmessage_item=array(
            "TicketMessageID" => $TicketMessageID,
            "TicketId" => $TicketId,
            "UserId" => $UserId,
            "AssistantId" => $AssistantId,
            "Date"=>$Date,
            "Content"=>$Content
        );
        array_push($ticketmessage_arr["ticketmessages"], $ticketmessage_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($ticketmessage_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("ticketmessage" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>