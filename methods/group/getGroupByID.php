<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/group.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$group = new Group($db);

// установим свойство ID записи для чтения 
$group->GroupID = isset($_GET['GroupID']) ? $_GET['GroupID'] : die();

// прочитаем детали группы для редактирования 
$group->getGroupByID();

// если есть ID
if ($group->GroupID != null) {

    // создание массива 
    $group_arr = array(
        "GroupID" => $group->GroupID,
        "GroupName" =>  $group->GroupName,
        "GroupImage" =>  $group->GroupImage,
        "GroupBio" =>  $group->GroupBio,
        "RolePostPrivelege" =>  $group->RolePostPrivelege
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($group_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что группы не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>