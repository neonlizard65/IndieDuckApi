<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/report.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$report = new Report($db);
// чтение монитора
$stmt = $report->getAllReports();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $report_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $report_item=array(
            "ReportID" => $ReportID,
            "UserId" => $UserId,
            "ReportedUserId" => $ReportedUserId,
            "ReportedProductId" => $ReportedProductId,
            "ReportedPostId" => $ReportedPostId,
            "ReportReasonId" => $ReportReasonId,
            "AdditionalInfo" => $AdditionalInfo,
            "IsResolved" => $IsResolved
        );
        array_push($report_arr, $report_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($report_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>