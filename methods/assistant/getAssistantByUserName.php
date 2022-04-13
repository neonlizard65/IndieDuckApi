<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/assistant.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$assistant = new Assistant($db);

// установим свойство ID записи для чтения 
$assistant->AssistantUserName = isset($_GET['AssistantUserName']) ? $_GET['AssistantUserName'] : die();

// прочитаем детали разраба для редактирования 
$assistant->getAssistantByUserName();

// если есть ID
if ($assistant->AssistantID != null) {

    // создание массива 
    $assistant_arr = array(
        "AssistantID" => $assistant->AssistantID,
        "AssistantUserName" => $assistant->AssistantUserName,
        "AssistantRealName" => $assistant->AssistantRealName,
        "AssistantPass" => $assistant->AssistantPass
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($assistant_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>