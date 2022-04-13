<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/reportreason.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$reportreason = new ReportReason($db);
// чтение монитора
$stmt = $reportreason->getReportReasons();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $reportreason_arr=array();
    $reportreason_arr["reportreasons"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $reportreason_item=array(
            "ReportReasonID" => $ReportReasonID,
            "ReasonName" => $ReasonName
        );
        array_push($reportreason_arr["reportreasons"], $reportreason_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($reportreason_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Причины не найдены."), JSON_UNESCAPED_UNICODE);
}
?>