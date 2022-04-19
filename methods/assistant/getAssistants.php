<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/assistant.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$assistant = new Assistant($db);
// чтение монитора
$stmt = $assistant->getAssistants();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $assistant_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $assistant_item=array(
            "AssistantID" => $AssistantID,
            "AssistantUserName" => $AssistantUserName,
            "AssistantRealName" => $AssistantRealName,
            "AssistantPass" => $AssistantPass
        );
        array_push($assistant_arr, $assistant_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($assistant_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>