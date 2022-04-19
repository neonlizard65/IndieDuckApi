<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/track.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$track = new Track($db);
// чтение 
$track->OSTId = isset($_GET["OSTId"]) ? $_GET["OSTId"] : die(); 

$stmt = $track->getTrackByOST();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $track_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $track_item=array(
            "TrackID" => $TrackID,
            "OSTId" => $OSTId,
            "DiscNumber" => $DiscNumber,
            "TrackNumber" => $TrackNumber,
            "SongName" => $SongName,
            "Duration" => $Duration
        );
        array_push($track_arr, $track_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($track_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("track" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>