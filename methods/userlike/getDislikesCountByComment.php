<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/userlike.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$userlike = new UserLike($db);
// чтение 
$userlike->CommentId = isset($_GET["CommentId"]) ? $_GET["CommentId"] : die(); 

$stmt = $userlike->getDislikesCountByComment();

if($stmt->rowCount() > 0){
    foreach ($stmt as $row) {
        echo $row[0];
    }
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("userlike" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>