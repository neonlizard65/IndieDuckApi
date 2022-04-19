<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/productpricelist.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$productpricelist = new ProductPriceList($db);
// чтение монитора
$stmt = $productpricelist->getPricesAll();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $productpricelist_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $productpricelist_item=array(
            "PriceListID" => $PriceListID,
            "ProductId" => $ProductId,
            "PriceCIS" => $PriceCIS,
            "PriceEU" => $PriceEU,
            "PriceUS" => $PriceUS
        );
        array_push($productpricelist_arr, $productpricelist_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($productpricelist_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Теги не найдены."), JSON_UNESCAPED_UNICODE);
}
?>