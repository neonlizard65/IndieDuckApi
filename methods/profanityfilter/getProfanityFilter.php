<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/profanityfilter.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$profanityfilter = new ProfanityFilter($db);
// чтение монитора
$stmt = $profanityfilter->getProfanityFilters();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $profanityfilter_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $profanityfilter_item=array(
            "ProfanityFilterID" => $ProfanityFilterID,
            "Word" => $Word
        );
        array_push($profanityfilter_arr, $profanityfilter_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($profanityfilter_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Список запреток не найдены."), JSON_UNESCAPED_UNICODE);
}
?>