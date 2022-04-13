<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/crowdfund.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$crowdfund = new Crowdfund($db);
// чтение 
$crowdfund->ProductId = isset($_GET["ProductId"]) ? $_GET["ProductId"] : die(); 

$stmt = $crowdfund->getCrowdfundFromProduct();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $crowdfund_arr=array();
    $crowdfund_arr["crowdfund"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $crowdfund_item=array(
            "CrowdfundID" => $CrowdfundID,
            "ProductId" =>  $ProductId,
            "CurrentSum" =>  $CurrentSum,
            "Goal" =>  $Goal,
            "MinSumForGame" =>  $MinSumForGame,
            "EndDate" =>  $EndDate
        );
        array_push($crowdfund_arr["crowdfund"], $crowdfund_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($crowdfund_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("crowdfund" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>