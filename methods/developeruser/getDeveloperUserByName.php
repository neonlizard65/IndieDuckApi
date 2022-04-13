<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/developeruser.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$developeruser = new DeveloperUser($db);

// установим свойство ID записи для чтения 
$developeruser->DeveloperUserName = isset($_GET['DeveloperUserName']) ? $_GET['DeveloperUserName'] : die();

// прочитаем детали разраба для редактирования 
$developeruser->getDeveloperUserByName();

// если есть ID
if ($developeruser->DeveloperUserID != null) {

    // создание массива 
    $developeruser_arr = array(
        "DeveloperUserID" => $developeruser->DeveloperUserID,
        "DeveloperUserName" => $developeruser->DeveloperUserName,
        "DeveloperUserPass" => $developeruser->DeveloperUserPass,
        "DeveloperUserEmail" => $developeruser->DeveloperUserEmail,
        "DeveloperUserGuardCode" => $developeruser->DeveloperUserGuardCode,
        "DeveloperId" => $developeruser->DeveloperId,
        "IsAdmin" => $IsAdmin

    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($developeruser_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>