<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/bundle.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$bundle = new Bundle($db);
// чтение монитора
$Date1 = isset($_GET['Date1']) ? $_GET['Date1'] : die();
$Date2 = isset($_GET['Date2']) ? $_GET['Date2'] : die();
$stmt = $bundle->getBundleByDates($Date1, $Date2);
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $bundle_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $bundle_item=array(
            "BundleID" => $BundleID,
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
        array_push($bundle_arr, $bundle_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($bundle_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>