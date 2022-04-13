<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом systemrequirement 
include_once '../../config/database.php';
include_once '../../models/systemrequirement.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$systemrequirement = new SystemRequirement($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$systemrequirement->SystemRequirementID = $data->SystemRequirementID;

if(isset($systemrequirement->SystemRequirementID)){
    // устанавливаем значения свойств  

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

	// обновление товара
	if ($systemrequirement->update()) {
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