<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/guide.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$guide = new Guide($db);

// установим свойство ID записи для чтения 
$guide->GuideID = isset($_GET['GuideID']) ? $_GET['GuideID'] : die();

// прочитаем детали разраба для редактирования 
$guide->getGuideByID();

// если есть ID
if ($guide->GuideID != null) {

    // создание массива 
    $guide_arr = array(
        "GuideID" => $guide->GuideID,
        "ProductId" => $guide->ProductId,
        "AuthorUserId" =>  $guide->AuthorUserId,
        "AuthorDevUserId" =>  $guide->AuthorDevUserId,
        "PostDate" =>  $guide->PostDate,
        "Header" =>  $guide->Header,
        "TextContent" => $guide->TextContent
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($guide_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>