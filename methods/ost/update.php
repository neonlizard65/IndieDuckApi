<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом ost 
include_once '../../config/database.php';
include_once '../../models/ost.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$ost = new OST($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$ost->OSTID = $data->OSTID;

if(isset($ost->OSTID)){
    // устанавливаем значения свойств  
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

	// обновление товара
	if ($ost->update()) {
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