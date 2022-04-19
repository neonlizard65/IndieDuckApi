<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/contestgame.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$contestgame = new ContestGame($db);
// чтение 
$contestgame->ContestId = isset($_GET["ContestId"]) ? $_GET["ContestId"] : die(); 

$stmt = $contestgame->getGamesByContest();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $contestgame_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $contestgame_item=array(
            "ContestGameID" => $ContestGameID,
            "ContestId" => $ContestId,
            "GameId" => $GameId
        );
        array_push($contestgame_arr, $contestgame_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($contestgame_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("contestgame" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>