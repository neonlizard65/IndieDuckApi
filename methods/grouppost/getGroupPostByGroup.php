<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/grouppost.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$grouppost = new GroupPost($db);
// чтение 
$grouppost->GroupId = isset($_GET["GroupId"]) ? $_GET["GroupId"] : die(); 

$stmt = $grouppost->getGroupPostByGroup();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $grouppost_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $grouppost_item=array(
            "GroupPostID" => $GroupPostID,
            "GroupId" => $GroupId,
            "AuthorUserId" =>  $AuthorUserId,
            "AuthorDevUserId" =>  $AuthorDevUserId,
            "PostDate" =>  $PostDate,
            "Header" =>  $Header,
            "TextContent" => $TextContent
        );
        array_push($grouppost_arr, $grouppost_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($grouppost_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("grouppost" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>