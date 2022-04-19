<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/thread.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$thread = new Thread($db);
// чтение 
$thread->AuthorUserId = isset($_GET["AuthorUserId"]) ? $_GET["AuthorUserId"] : die(); 

$stmt = $thread->getThreadByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $thread_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $thread_item=array(
            "ThreadID" => $ThreadID,
            "ProductId" => $ProductId,
            "AuthorUserId" =>  $AuthorUserId,
            "AuthorDevUserId" =>  $AuthorDevUserId,
            "PostDate" =>  $PostDate,
            "Header" =>  $Header,
            "TextContent" => $TextContent
        );
        array_push($thread_arr, $thread_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($thread_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("thread" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>