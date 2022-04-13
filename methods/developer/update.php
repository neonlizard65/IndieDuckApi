<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом developer 
include_once '../../config/database.php';
include_once '../../models/developer.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$developer = new Developer($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$developer->DeveloperID = $data->DeveloperID;

if(isset($developer->DeveloperID)){
    // устанавливаем значения свойств  

    $developer->DeveloperName = $data->DeveloperName;
    $developer->DeveloperLogo = $data->DeveloperLogo;
    $developer->DeveloperCard = $data->DeveloperCard;
    $developer->DeveloperYoutube = $data->DeveloperYoutube;
    $developer->DeveloperTwitch = $data->DeveloperTwitch;
    $developer->DeveloperTwitter = $data->DeveloperTwitter;
    $developer->DeveloperBio = $data->DeveloperBio;
    $developer->CountryId = $data->CountryId;

	// обновление товара
	if ($developer->update()) {
	    // установим код ответа - 200 ok 
	    http_response_code(200);
	    // сообщим пользователю 
	    echo json_encode(array("message" => "Разработчик был обновлён."), JSON_UNESCAPED_UNICODE);
	}

	// если не удается обновить товар, сообщим пользователю 
	else {
	    // код ответа - 503 Сервис не доступен 
	    http_response_code(503);
	    // сообщение пользователю 
	    echo json_encode(array("message" => "Невозможно обновить разработчика."), JSON_UNESCAPED_UNICODE);
	}
}
else{
     http_response_code(404);
     echo "Введите индекс";
}
?>