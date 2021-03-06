<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/postmedia.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$postmedia = new PostMedia($db);
// чтение 
$postmedia->PostId = isset($_GET["PostId"]) ? $_GET["PostId"] : die(); 

$stmt = $postmedia->getMediaByPost();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $postmedia_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $postmedia_item=array(
            "PostMediaID" => $PostMediaID,
            "PostId" => $PostId,
            "MediaContent" => $MediaContent
        );
        array_push($postmedia_arr, $postmedia_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($postmedia_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("postmedia" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>