<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/postcommentmedia.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$postcommentmedia = new PostCommentMedia($db);
// чтение 
$postcommentmedia->PostCommentId = isset($_GET["PostCommentId"]) ? $_GET["PostCommentId"] : die(); 

$stmt = $postcommentmedia->getMediaByPostComment();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $postcommentmedia_arr=array();
    $postcommentmedia_arr["postcommentmedia"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $postcommentmedia_item=array(
            "PostCommentMediaID" => $PostCommentMediaID,
            "PostCommentId" => $PostCommentId,
            "MediaContent" => $MediaContent
        );
        array_push($postcommentmedia_arr["postcommentmedia"], $postcommentmedia_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($postcommentmedia_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("postcommentmedia" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>