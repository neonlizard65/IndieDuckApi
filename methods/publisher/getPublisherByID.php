<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/publisher.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$publisher = new Publisher($db);

// установим свойство ID записи для чтения 
$publisher->PublisherID = isset($_GET['PublisherID']) ? $_GET['PublisherID'] : die();

// прочитаем детали разраба для редактирования 
$publisher->getPublisherByID();

// если есть ID
if ($publisher->PublisherID != null) {

    // создание массива 
    $publisher_arr = array(
        "PublisherID" => $publisher->PublisherID,
        "PublisherName" => $publisher->PublisherName,
        "PublisherLogo" => $publisher->PublisherLogo
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($publisher_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>