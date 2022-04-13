<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/cdkey.php';

$database = new Database();
$db = $database->getConnection();

$cdkey = new CDKey($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));


$cdkey->ProductId = $data->ProductId;
// убеждаемся, что данные не пусты 
// создание товара 
if($cdkey->create()){

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
?>