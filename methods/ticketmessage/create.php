<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/ticketmessage.php';

$database = new Database();
$db = $database->getConnection();

$ticketmessage = new TicketMessage($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    !empty($data->TicketId) &&
    !empty($data->Date) &&
    !empty($data->Content)
    ) 
{
    // устанавливаем значения свойств товара 
    $ticketmessage->TicketId = $data->TicketId;
    $ticketmessage->UserId = $data->UserId;
    $ticketmessage->DeveloperUserId = $data->DeveloperUserId;
    $ticketmessage->AssistantId = $data->AssistantId;
    $ticketmessage->Date = $data->Date;
    $ticketmessage->Content = $data->Content;

    // создание товара 
    if($ticketmessage->create()){
        // установим код ответа - 201 создано 
        http_response_code(201);
        // сообщим пользователю 
        echo json_encode(array("message" => "Группа добавлена."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {
        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "Невозможно добавить группу."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно создать группу. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>