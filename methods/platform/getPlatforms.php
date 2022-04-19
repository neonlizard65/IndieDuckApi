<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/platform.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$platform = new Platform($db);
// чтение монитора
$stmt = $platform->getPlatforms();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $platform_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $platform_item=array(
            "PlatformID" => $PlatformID,
            "Name" => $Name
        );
        array_push($platform_arr, $platform_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($platform_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Платформы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>