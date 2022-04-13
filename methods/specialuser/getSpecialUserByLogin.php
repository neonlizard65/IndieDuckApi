<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/specialuser.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$specialuser = new SpecialUser($db);

// установим свойство ID записи для чтения 
$specialuser->Login = isset($_GET['Login']) ? $_GET['Login'] : die();

// прочитаем детали группы для редактирования 
$specialuser->getSpecialUserByLogin();

// если есть ID
if ($specialuser->SpecialUserID != null) {

    // создание массива 
    $specialuser_arr = array(
        "SpecialUserID" => $specialuser->SpecialUserID,
        "Login" =>  $specialuser->Login,
        "Pass" =>  $specialuser->Pass,
        "RoleId" =>  $specialuser->RoleId
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($specialuser_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что группы не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>