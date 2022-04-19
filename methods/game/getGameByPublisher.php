<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/game.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$game = new Game($db);
// чтение 
$game->PublisherId = isset($_GET["PublisherId"]) ? $_GET["PublisherId"] : die(); 

$stmt = $game->getGameByPublisher();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $game_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $game_item=array(
            "GameID" => $GameID,
            "Name" =>  $Name,
            "ReleaseDate" =>  $ReleaseDate,
            "DeveloperId" =>  $DeveloperId,
            "PublisherId" =>  $PublisherId,
            "Discount" => $Discount,
            "ShortBio" =>  $ShortBio,
            "About" =>  $About,
            "FranchiseId" =>  $FranchiseId,
            "FranchiseName" =>  $FranchiseName,
            "AgeRatingESRB" =>  $AgeRatingESRB
        );
        array_push($game_arr, $game_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($game_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("game" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>