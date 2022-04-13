<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/contestpost.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$contestpost = new ContestPost($db);

// установим свойство ID записи для чтения 
$contestpost->ContestPostID = isset($_GET['ContestPostID']) ? $_GET['ContestPostID'] : die();

// прочитаем детали разраба для редактирования 
$contestpost->getContestPostByID();

// если есть ID
if ($contestpost->ContestPostID != null) {

    // создание массива 
    $contestpost_arr = array(
        "ContestPostID" => $contestpost->ContestPostID,
        "ContestId" => $contestpost->ContestId,
        "AuthorUserId" =>  $contestpost->AuthorUserId,
        "AuthorDevUserId" =>  $contestpost->AuthorDevUserId,
        "PostDate" =>  $contestpost->PostDate,
        "Header" =>  $contestpost->Header,
        "TextContent" => $contestpost->TextContent
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($contestpost_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>