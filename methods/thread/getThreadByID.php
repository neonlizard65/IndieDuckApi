<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/thread.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$thread = new Thread($db);

// установим свойство ID записи для чтения 
$thread->ThreadID = isset($_GET['ThreadID']) ? $_GET['ThreadID'] : die();

// прочитаем детали разраба для редактирования 
$thread->getThreadByID();

// если есть ID
if ($thread->ThreadID != null) {

    // создание массива 
    $thread_arr = array(
        "ThreadID" => $thread->ThreadID,
        "ProductId" => $thread->ProductId,
        "AuthorUserId" =>  $thread->AuthorUserId,
        "AuthorDevUserId" =>  $thread->AuthorDevUserId,
        "PostDate" =>  $thread->PostDate,
        "Header" =>  $thread->Header,
        "TextContent" => $thread->TextContent
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($thread_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>