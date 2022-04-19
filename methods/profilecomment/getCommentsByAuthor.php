<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/profilecomment.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$profilecomment = new ProfileComment($db);
// чтение 
$profilecomment->AuthorId = isset($_GET["AuthorId"]) ? $_GET["AuthorId"] : die(); 

$stmt = $profilecomment->getCommentsByAuthor();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $profilecomment_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $profilecomment_item=array(
            "ProfileCommentID" => $ProfileCommentID,
            "AuthorId" => $AuthorId,
            "UserId" => $UserId,
            "Content" => $Content,
            "Date" => $Date
        );
        array_push($profilecomment_arr, $profilecomment_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($profilecomment_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("profilecomment" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>