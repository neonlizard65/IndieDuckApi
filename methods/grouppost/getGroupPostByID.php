<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/grouppost.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$grouppost = new GroupPost($db);

// установим свойство ID записи для чтения 
$grouppost->GroupPostID = isset($_GET['GroupPostID']) ? $_GET['GroupPostID'] : die();

// прочитаем детали разраба для редактирования 
$grouppost->getGroupPostByID();

// если есть ID
if ($grouppost->GroupPostID != null) {

    // создание массива 
    $grouppost_arr = array(
        "GroupPostID" => $grouppost->GroupPostID,
        "GroupId" => $grouppost->GroupId,
        "AuthorUserId" =>  $grouppost->AuthorUserId,
        "AuthorDevUserId" =>  $grouppost->AuthorDevUserId,
        "PostDate" =>  $grouppost->PostDate,
        "Header" =>  $grouppost->Header,
        "TextContent" => $grouppost->TextContent
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($grouppost_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>