<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/achievement.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$achievement = new Achievement($db);

// установим свойство ID записи для чтения 
$achievement->AchievementID = isset($_GET['AchievementID']) ? $_GET['AchievementID'] : die();

// прочитаем детали разраба для редактирования 
$achievement->getAchievementByID();

// если есть ID
if ($achievement->AchievementID != null) {

    // создание массива 
    $achievement_arr = array(
        "AchievementID" => $achievement->AchievementID,
        "ProductId" =>  $achievement->ProductId,
        "Name" =>  $achievement->Name,
        "Image" =>  $achievement->Image,
        "Description" =>  $achievement->Description,
        "XP" =>  $achievement->XP,
        "IsHidden" =>  $achievement->IsHidden
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($achievement_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>