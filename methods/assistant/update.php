<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом assistant 
include_once '../../config/database.php';
include_once '../../models/assistant.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$assistant = new Assistant($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$assistant->AssistantID = $data->AssistantID;

if(isset($assistant->AssistantID)){
    // устанавливаем значения свойств  

    $assistant->AssistantUserName = $data->AssistantUserName;
    $assistant->AssistantRealName = $data->AssistantRealName;
    $assistant->AssistantPass = $data->AssistantPass;

	// обновление товара
	if ($assistant->update()) {
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