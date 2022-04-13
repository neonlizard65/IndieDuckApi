<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../config/database.php';
include_once '../../models/developer.php';

$database = new Database();
$db = $database->getConnection();

$developer = new Developer($db);

// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
    !empty($data->DeveloperName) &&
    !empty($data->DeveloperCard) &&
    !empty($data->CountryId)
    ) 
{
    // устанавливаем значения свойств товара 
    $developer->DeveloperName = $data->DeveloperName;
    $developer->DeveloperLogo = $data->DeveloperLogo;
    $developer->DeveloperCard = $data->DeveloperCard;
    $developer->DeveloperYoutube = $data->DeveloperYoutube;
    $developer->DeveloperTwitch = $data->DeveloperTwitch;
    $developer->DeveloperTwitter = $data->DeveloperTwitter;
    $developer->DeveloperBio = $data->DeveloperBio;
    $developer->CountryId = $data->CountryId;

    // создание товара 
    if($developer->create()){
        // установим код ответа - 201 создано 
        http_response_code(201);
        // сообщим пользователю 
        echo json_encode(array("message" => "Разработчик добавлен."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {
        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "Невозможно добавить разработчика."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно создать разработчика. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>