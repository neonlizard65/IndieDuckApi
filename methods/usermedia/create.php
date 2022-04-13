<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/usermedia.php';

$database = new Database();
$db = $database->getConnection();

$usermedia = new UserMedia($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    !empty($data->UserId) &&
    !empty($data->Content) &&
    !empty($data->Date) 
    ) 
{
    // устанавливаем значения свойств товара 
    $usermedia->UserId = $data->UserId;
    $usermedia->ProductId = $data->ProductId;
    $usermedia->Content = $data->Content;
    $usermedia->Date = $data->Date;
    $usermedia->Title = $data->Title;

    // создание товара 
    if($usermedia->create()){
        // установим код ответа - 201 создано 
        http_response_code(201);
        // сообщим пользователю 
        echo json_encode(array("usermedia" => "Группа добавлена."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {
        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("usermedia" => "Невозможно добавить группу."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("usermedia" => "Невозможно создать группу. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>