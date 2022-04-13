<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключим файл для соединения с базой и объектом ticketmessage 
include_once '../../config/database.php';
include_once '../../models/ticketmessage.php';


// получаем соединение с БД 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$ticketmessage = new TicketMessage($db);

// получаем id товара 
$data = json_decode(file_get_contents("php://input"));

// установим id товара для удаления 
$ticketmessage->TicketMessageID = $data->TicketMessageID;
if(!empty($ticketmessage->TicketMessageID)){
// удаление товара 
    if ($ticketmessage->delete()) {

        // код ответа - 200 ok 
        http_response_code(200);

        // сообщение пользователю 
        echo json_encode(array("message" => "Группа была удалена."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается удалить товар 
    else {

        // код ответа - 503 Сервис не доступен 
        http_response_code(503);

        // сообщим об этом пользователю 
        echo json_encode(array("message" => "Не удалось удалить группу."));
    }
}
else{
    http_response_code(404);
    echo "Введите индекс для удаления";
}
?>