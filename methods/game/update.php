<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом game 
include_once '../../config/database.php';
include_once '../../models/game.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$game = new Game($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$game->GameID = $data->GameID;

if(isset($game->GameID)){
    // устанавливаем значения свойств  

    $game->Name = $data->Name;
    $game->ReleaseDate = $data->ReleaseDate;
    $game->DeveloperId = $data->DeveloperId;
    $game->PublisherId = $data->PublisherId;
    $game->Discount = $data->Discount;
    $game->ShortBio = $data->ShortBio;
    $game->About = $data->About;
    $game->FranchiseId = $data->FranchiseId;
    $game->FranchiseName = $data->FranchiseName;
    $game->AgeRatingESRB = $data->AgeRatingESRB;

	// обновление товара
	if ($game->update()) {
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