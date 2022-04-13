<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/bundle.php';

$database = new Database();
$db = $database->getConnection();

$bundle = new Bundle($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    !empty($data->Name) &&
    !empty($data->ReleaseDate) &&
    !empty($data->DeveloperId) &&
    !empty($data->PublisherId) &&
    !empty($data->ShortBio) &&
    !empty($data->About)&&
    !empty($data->AgeRatingESRB)

    ) 
{
    // устанавливаем значения свойств товара 
    $bundle->Name = $data->Name;
    $bundle->ReleaseDate = $data->ReleaseDate;
    $bundle->DeveloperId = $data->DeveloperId;
    $bundle->PublisherId = $data->PublisherId;
    $bundle->Discount = $data->Discount;
    $bundle->ShortBio = $data->ShortBio;
    $bundle->About = $data->About;
    $bundle->FranchiseId = $data->FranchiseId;
    $bundle->FranchiseName = $data->FranchiseName;
    $bundle->AgeRatingESRB = $data->AgeRatingESRB;

    // создание товара 
    if($bundle->create()){
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