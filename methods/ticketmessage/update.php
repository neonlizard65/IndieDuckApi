<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом ticketmessage 
include_once '../../config/database.php';
include_once '../../models/ticketmessage.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$ticketmessage = new TicketMessage($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$ticketmessage->TicketMessageID = $data->TicketMessageID;

if(isset($ticketmessage->TicketMessageID)){
    // устанавливаем значения свойств  
    $ticketmessage->TicketId = $data->TicketId;
    $ticketmessage->UserId = $data->UserId;
    $ticketmessage->DeveloperUserId = $data->DeveloperUserId;
    $ticketmessage->AssistantId = $data->AssistantId;
    $ticketmessage->Date = $data->Date;
    $ticketmessage->Content = $data->Content;

	// обновление товара
	if ($ticketmessage->update()) {
	    // установим код ответа - 200 ok 
	    http_response_code(200);
	    // сообщим пользователю 
	    echo json_encode(array("message" => "Группа была обновлена."), JSON_UNESCAPED_UNICODE);
	}

	// если не удается обновить товар, сообщим пользователю 
	else {
	    // код ответа - 503 Сервис не доступен 
	    http_response_code(503);
	    // сообщение пользователю 
	    echo json_encode(array("message" => "Невозможно обновить группу."), JSON_UNESCAPED_UNICODE);
	}
}
else{
     http_response_code(404);
     echo "Введите индекс";
}
?>