<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/usermedia.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$usermedia = new UserMedia($db);
// чтение 
$usermedia->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $usermedia->getAllUserMedia();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $usermedia_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $usermedia_item=array(
            "UserMediaID" => $UserMediaID,
            "UserId" => $UserId,
            "ProductId" => $ProductId,
            "Content" => $Content,
            "Date"=>$Date,
            "Title"=>$Title
        );
        array_push($usermedia_arr, $usermedia_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($usermedia_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("usermedia" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>