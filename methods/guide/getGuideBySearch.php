<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/guide.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$guide = new Guide($db);
// чтение монитора
$search = isset($_GET['Search']) ? $_GET['Search'] : die();
$stmt = $guide->getGuideBySearch($search);
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $guide_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $guide_item=array(
            "GuideID" => $GuideID,
            "ProductId" => $ProductId,
            "AuthorUserId" =>  $AuthorUserId,
            "AuthorDevUserId" =>  $AuthorDevUserId,
            "PostDate" =>  $PostDate,
            "Header" =>  $Header,
            "TextContent" => $TextContent
        );
        array_push($guide_arr, $guide_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($guide_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>