<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/postcomment.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$postcomment = new PostComment($db);
// чтение 
$postcomment->DevUserId = isset($_GET["DevUserId"]) ? $_GET["DevUserId"] : die(); 

$stmt = $postcomment->getCommentsByDevUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $postcomment_arr=array();
    $postcomment_arr["postcomment"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $postcomment_item=array(
            "PostCommentID" => $PostCommentID,
            "UserId" => $UserId,
            "DevUserId" => $DevUserId,
            "PostId" => $PostId,
            "Content" => $Content
        );
        array_push($postcomment_arr["postcomment"], $postcomment_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($postcomment_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("postcomment" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>