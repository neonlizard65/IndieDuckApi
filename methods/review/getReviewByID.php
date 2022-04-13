<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/review.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$review = new Review($db);

// установим свойство ID записи для чтения 
$review->ReviewID = isset($_GET['ReviewID']) ? $_GET['ReviewID'] : die();

// прочитаем детали разраба для редактирования 
$review->getReviewByID();

// если есть ID
if ($review->ReviewID != null) {

    // создание массива 
    $review_arr = array(
        "ReviewID" => $review->ReviewID,
        "ProductId" => $review->ProductId,
        "Rating" => $review->Rating,
        "AuthorUserId" =>  $review->AuthorUserId,
        "AuthorDevUserId" =>  $review->AuthorDevUserId,
        "PostDate" =>  $review->PostDate,
        "Header" =>  $review->Header,
        "TextContent" => $review->TextContent
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($review_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>