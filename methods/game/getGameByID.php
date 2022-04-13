<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/game.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$game = new Game($db);

// установим свойство ID записи для чтения 
$game->GameID = isset($_GET['GameID']) ? $_GET['GameID'] : die();

// прочитаем детали разраба для редактирования 
$game->getGameByID();

// если есть ID
if ($game->GameID != null) {

    // создание массива 
    $game_arr = array(
        "GameID" => $game->GameID,
        "Name" =>  $game->Name,
        "ReleaseDate" =>  $game->ReleaseDate,
        "DeveloperId" =>  $game->DeveloperId,
        "PublisherId" =>  $game->PublisherId,
        "Discount" => $game->Discount,
        "ShortBio" =>  $game->ShortBio,
        "About" =>  $game->About,
        "FranchiseId" =>  $game->FranchiseId,
        "FranchiseName" =>  $game->FranchiseName,
        "AgeRatingESRB" =>  $game->AgeRatingESRB
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($game_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>