<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/supportticket.php';

$database = new Database();
$db = $database->getConnection();

$supportticket = new SupportTicket($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    (!empty($data->UserId) || !empty($data->DeveloperUserId) ) &&
    !empty($data->TicketReasonId)
    ) 
{
    // устанавливаем значения свойств товара 
    $supportticket->UserId = $data->UserId;
    $supportticket->DeveloperUserId = $data->DeveloperUserId;

    $supportticket->ProductId = $data->ProductId;
    $supportticket->TicketReasonId = $data->TicketReasonId;
    $supportticket->AdditionalInfo = $data->AdditionalInfo;
    $supportticket->IsResolved = $data->IsResolved; 

    // создание товара 
    if($supportticket->create()){
        // установим код ответа - 201 создано 
        http_response_code(201);
        // сообщим пользователю 
        echo json_encode(array("message" => "Билет добавлен."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {
        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "Невозможно добавить билет."), JSON_UNESCAPED_UNICODE);
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