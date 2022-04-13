<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/systemrequirement.php';

$database = new Database();
$db = $database->getConnection();

$systemrequirement = new SystemRequirement($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    !empty($data->ProductId) &&
    !empty($data->PlatformId)&&
    !empty($data->OS) &&
    !empty($data->CPU) &&
    !empty($data->RAM) &&
    !empty($data->GPU) &&
    !empty($data->DirectX) &&
    !empty($data->Storage) &&
    !empty($data->SoundCard) &&
    !empty($data->Network) &&
    !empty($data->AdditionalNotes)  
    ) 
{
    // устанавливаем значения свойств товара 
    $systemrequirement->ProductId = $data->ProductId;
    $systemrequirement->PlatformId = $data->PlatformId;
    $systemrequirement->IsMinimumRecommended = $data->IsMinimumRecommended;
    $systemrequirement->OS = $data->OS;
    $systemrequirement->CPU = $data->CPU;
    $systemrequirement->RAM = $data->RAM;
    $systemrequirement->GPU = $data->GPU;
    $systemrequirement->OS = $data->OS;
    $systemrequirement->DirectX = $data->DirectX;
    $systemrequirement->Storage = $data->Storage;
    $systemrequirement->SoundCard = $data->SoundCard;
    $systemrequirement->Network = $data->Network;
    $systemrequirement->AdditionalNotes = $data->AdditionalNotes;

    // создание товара 
    if($systemrequirement->create()){
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