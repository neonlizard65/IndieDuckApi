<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/ost.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$ost = new OST($db);
// чтение 
$ost->GameId = isset($_GET["GameId"]) ? $_GET["GameId"] : die(); 

$stmt = $ost->getOSTByGame();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $ost_arr=array();
    $ost_arr["osts"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $ost_item=array(
            "OSTID" => $OSTID,
            "GameId" => $GameId,
            "Composer" => $Composer,
            "Artist" => $Artist,
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
        array_push($ost_arr["osts"], $ost_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($ost_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("ost" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>