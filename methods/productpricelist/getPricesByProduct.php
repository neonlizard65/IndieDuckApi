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
// установим свойство ID записи для чтения 
$productpricelist->ProductId = isset($_GET['ProductId']) ? $_GET['ProductId'] : die();

// прочитаем детали группы для редактирования 
$productpricelist->getPricesByProduct();

// если есть ID
if ($productpricelist->ProductId != null) {

    // создание массива 
    $productpricelist_arr = array(
        "PriceListID" => $productpricelist->PriceListID,
        "ProductId" =>  $productpricelist->ProductId,
        "PriceCIS" =>  $productpricelist->PriceCIS,
        "PriceEU" =>  $productpricelist->PriceEU,
        "PriceUS" =>  $productpricelist->PriceUS
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($productpricelist_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что группы не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>