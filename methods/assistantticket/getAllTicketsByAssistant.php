<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/assistantticket.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$assistantticket = new AssistantTicket($db);
// чтение 
$assistantticket->AssistantId = isset($_GET["AssistantId"]) ? $_GET["AssistantId"] : die(); 

$stmt = $assistantticket->getAllTicketsByAssistants();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $assistantticket_arr=array();
    $assistantticket_arr["assistanttickets"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $assistantticket_item=array(
            "AssistantTicketID" => $AssistantTicketID,
            "TicketId" => $TicketId,
            "AssistantId" => $AssistantId
        );
        array_push($assistantticket_arr["assistanttickets"], $assistantticket_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($assistantticket_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("assistantticket" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>