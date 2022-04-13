<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/contest.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$contest = new Contest($db);

// установим свойство ID записи для чтения 
$contest->ContestID = isset($_GET['ContestID']) ? $_GET['ContestID'] : die();

// прочитаем детали разраба для редактирования 
$contest->getContestByID();

// если есть ID
if ($contest->ContestID != null) {

    // создание массива 
    $contest_arr = array(
        "ContestID" => $contest->ContestID,
        "ContestName" =>  $contest->ContestName,
        "ContestImage" =>  $contest->ContestImage,
        "StartDate" =>  $contest->StartDate,
        "EndDate" =>  $contest->EndDate,
        "DeveloperWinner" =>  $contest->DeveloperWinner,
        "UserWinner" =>  $contest->UserWinner,
        "UserXPReward" =>  $contest->UserXPReward,
        "DevMoneyReward" =>  $contest->DevMoneyReward,
        "ContestDescription" =>  $contest->ContestDescription
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($contest_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>