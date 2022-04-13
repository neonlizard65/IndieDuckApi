<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом userfriend 
include_once '../../config/database.php';
include_once '../../models/userfriend.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$userfriend = new UserFriend($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$userfriend->UserFriendID = $data->UserFriendID;

if(isset($userfriend->UserFriendID)){
    // устанавливаем значения свойств  
    $userfriend->UserId = $data->UserId;
    $userfriend->FriendId = $data->FriendId;
    $userfriend->IsSent = $data->IsSent;
    $userfriend->IsAccepted = $data->IsAccepted;
    $userfriend->IsBlocked = $data->IsBlocked;

	// обновление товара
	if ($userfriend->update()) {
	    // установим код ответа - 200 ok 
	    http_response_code(200);
	    // сообщим пользователю 
	    echo json_encode(array("userfriend" => "Группа была обновлена."), JSON_UNESCAPED_UNICODE);
	}

	// если не удается обновить товар, сообщим пользователю 
	else {
	    // код ответа - 503 Сервис не доступен 
	    http_response_code(503);
	    // сообщение пользователю 
	    echo json_encode(array("userfriend" => "Невозможно обновить группу."), JSON_UNESCAPED_UNICODE);
	}
}
else{
     http_response_code(404);
     echo "Введите индекс";
}
?>