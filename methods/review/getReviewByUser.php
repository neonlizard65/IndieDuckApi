<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/review.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$review = new Review($db);
// чтение 
$review->AuthorUserId = isset($_GET["AuthorUserId"]) ? $_GET["AuthorUserId"] : die(); 

$stmt = $review->getReviewByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $review_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $review_item=array(
            "ReviewID" => $ReviewID,
            "ProductId" => $ProductId,
            "Rating" => $Rating,
            "AuthorUserId" =>  $AuthorUserId,
            "AuthorDevUserId" =>  $AuthorDevUserId,
            "PostDate" =>  $PostDate,
            "Header" =>  $Header,
            "TextContent" => $TextContent
        );
        array_push($review_arr, $review_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($review_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("review" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>