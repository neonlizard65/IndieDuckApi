<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/dlc.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$dlc = new DLC($db);
// чтение 
$dlc->DeveloperId = isset($_GET["DeveloperId"]) ? $_GET["DeveloperId"] : die(); 

$stmt = $dlc->getDLCByDeveloper();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $dlc_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $dlc_item=array(
            "DLCID" => $DLCID,
            "GameId" => $GameId,
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
        array_push($dlc_arr, $dlc_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($dlc_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("dlc" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>