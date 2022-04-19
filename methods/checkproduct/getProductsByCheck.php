<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/checkproduct.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$checkproduct = new CheckProduct($db);
// чтение 
$checkproduct->CheckId = isset($_GET["CheckId"]) ? $_GET["CheckId"] : die(); 

$stmt = $checkproduct->getProductsByCheck();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $checkproduct_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $checkproduct_item=array(
            "CheckProductID" => $CheckProductID,
            "ProductId" => $ProductId,
            "CheckId" => $CheckId
        );
        array_push($checkproduct_arr, $checkproduct_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($checkproduct_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("checkproduct" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>