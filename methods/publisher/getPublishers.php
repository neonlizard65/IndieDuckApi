<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/publisher.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$publisher = new Publisher($db);
// чтение монитора
$stmt = $publisher->getPublishers();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $publisher_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $publisher_item=array(
            "PublisherID" => $PublisherID,
            "PublisherName" => $PublisherName,
            "PublisherLogo" => $PublisherLogo
        );
        array_push($publisher_arr, $publisher_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($publisher_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Роли не найдены."), JSON_UNESCAPED_UNICODE);
}
?>