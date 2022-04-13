<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/ost.php';

$database = new Database();
$db = $database->getConnection();

$ost = new OST($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    !empty($data->GameId) &&
    !empty($data->Composer) &&
    !empty($data->Artist) &&
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
    $ost->GameId = $data->GameId;
    $ost->Composer = $data->Composer;
    $ost->Artist = $data->Artist;
    $ost->Name = $data->Name;
    $ost->ReleaseDate = $data->ReleaseDate;
    $ost->DeveloperId = $data->DeveloperId;
    $ost->PublisherId = $data->PublisherId;
    $ost->Discount = $data->Discount;
    $ost->ShortBio = $data->ShortBio;
    $ost->About = $data->About;
    $ost->FranchiseId = $data->FranchiseId;
    $ost->FranchiseName = $data->FranchiseName;
    $ost->AgeRatingESRB = $data->AgeRatingESRB;

    // создание товара 
    if($ost->create()){
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