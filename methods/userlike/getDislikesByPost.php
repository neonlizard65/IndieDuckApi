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
$userlike->PostId = isset($_GET["PostId"]) ? $_GET["PostId"] : die(); 

$stmt = $userlike->getDislikesByPost();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $userlike_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $userlike_item=array(
            "UserLikeID" => $UserLikeID,
            "UserId" => $UserId,
            "PostId" => $PostId,
            "CommentId" => $CommentId,
            "ContestGameId" => $ContestGameId,
            "LikeDislike" => $LikeDislike
        );
        array_push($userlike_arr, $userlike_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($userlike_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("userlike" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>