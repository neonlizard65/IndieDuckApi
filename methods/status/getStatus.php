<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/status.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$status = new Status($db);
// чтение монитора
$stmt = $status->getStatuses();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $status_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $status_item=array(
            "StatusID" => $StatusID,
            "StatusName" => $StatusName,
            "StatusIcon" => $StatusIcon,
            "StatusColor" => $StatusColor
        );
        array_push($status_arr, $status_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($status_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Статусы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>