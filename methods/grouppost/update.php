<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом grouppost 
include_once '../../config/database.php';
include_once '../../models/grouppost.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$grouppost = new GroupPost($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$grouppost->GroupPostID = $data->GroupPostID;

if(isset($grouppost->GroupPostID)){
    // устанавливаем значения свойств  

    $grouppost->GroupId = $data->GroupId;
    $grouppost->AuthorUserId = $data->AuthorUserId;
    $grouppost->AuthorDevUserId = $data->AuthorDevUserId;
    $grouppost->PostDate = $data->PostDate;
    $grouppost->Header = $data->Header;
    $grouppost->TextContent = $data->TextContent;
    

	// обновление товара
	if ($grouppost->update()) {
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