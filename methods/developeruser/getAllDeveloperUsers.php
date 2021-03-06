<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/developeruser.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$developeruser = new DeveloperUser($db);
// чтение монитора
$stmt = $developeruser->getAllDeveloperUsers();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $developeruser_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $developeruser_item=array(
            "DeveloperUserID" => $DeveloperUserID,
            "DeveloperUserName" => $DeveloperUserName,
            "DeveloperUserPass" => $DeveloperUserPass,
            "DeveloperUserEmail" => $DeveloperUserEmail,
            "DeveloperUserGuardCode" => $DeveloperUserGuardCode,
            "DeveloperId" => $DeveloperId,
            "IsAdmin" => $IsAdmin

        );
        array_push($developeruser_arr, $developeruser_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($developeruser_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Разработчики не найдены."), JSON_UNESCAPED_UNICODE);
}
?>