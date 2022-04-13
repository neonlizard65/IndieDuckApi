<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/contestpost.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$contestpost = new ContestPost($db);
// чтение 
$contestpost->AuthorDevUserId = isset($_GET["AuthorDevUserId"]) ? $_GET["AuthorDevUserId"] : die(); 

$stmt = $contestpost->getContestPostByDeveloperUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $contestpost_arr=array();
    $contestpost_arr["contestpost"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $contestpost_item=array(
            "ContestPostID" => $ContestPostID,
            "ContestId" => $ContestId,
            "AuthorUserId" =>  $AuthorUserId,
            "AuthorDevUserId" =>  $AuthorDevUserId,
            "PostDate" =>  $PostDate,
            "Header" =>  $Header,
            "TextContent" => $TextContent
        );
        array_push($contestpost_arr["contestpost"], $contestpost_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($contestpost_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("contestpost" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>