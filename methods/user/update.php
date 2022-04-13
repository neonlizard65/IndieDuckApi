<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом user 
include_once '../../config/database.php';
include_once '../../models/user.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$user = new User($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$user->UserID = $data->UserID;

if(isset($user->UserID)){
    // устанавливаем значения свойств  

    $user->UserName = $data->UserName;
    $user->UserPassword = $data->UserPassword;
    $user->UserEmail = $data->UserEmail;
    $user->UserPhone = $data->UserPhone;
    $user->UserLevelId = $data->UserLevelId;
    $user->UserAvatar = $data->UserAvatar;
    $user->UserXP = $data->UserXP;
    $user->ProfileBackground = $data->ProfileBackground;
    $user->IsPrivate = $data->IsPrivate;
    $user->StatusId = $data->StatusId;
    $user->UserRealName = $data->UserRealName;
    $user->UserCountryId = $data->UserCountryId;
    $user->Bio = $data->Bio;
    $user->EmailSubscription = $data->EmailSubscription;
    $user->LastOnline = $data->LastOnline;
    $user->ContentPrivacyTypeId = $data->ContentPrivacyTypeId;

	// обновление товара
	if ($user->update()) {
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