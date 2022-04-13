<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом build 
include_once '../../config/database.php';
include_once '../../models/build.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$build = new Build($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$build->BuildID = $data->BuildID;

if(isset($build->BuildID)){
    // устанавливаем значения свойств  

    $build->ProductId = $data->ProductId;
    $build->DeveloperUserId = $data->DeveloperUserId;
    $build->Version = $data->Version;
    $build->Date = $data->Date;
    $build->BuildContent = $data->BuildContent;
    $build->IsDemo = $data->IsDemo;

	// обновление товара
	if ($build->update()) {
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