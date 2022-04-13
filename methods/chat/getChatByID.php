<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/chat.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$chat = new Chat($db);

// установим свойство ID записи для чтения 
$chat->ChatID = isset($_GET['ChatID']) ? $_GET['ChatID'] : die();

// прочитаем детали разраба для редактирования 
$chat->getChatByID();

// если есть ID
if ($chat->ChatID != null) {

    // создание массива 
    $chat_arr = array(
        "ChatID" => $chat->ChatID,
        "ChatName" =>  $chat->ChatName,
        "IsPrivateChat" =>  $chat->IsPrivateChat,
        "GroupId" =>  $chat->GroupId
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($chat_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Чата по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>