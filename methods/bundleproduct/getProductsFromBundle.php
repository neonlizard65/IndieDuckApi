<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/bundleproduct.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$bundleproduct = new BundleProduct($db);
// чтение 
$bundleproduct->BundleId = isset($_GET["BundleId"]) ? $_GET["BundleId"] : die(); 

$stmt = $bundleproduct->getProductsFromBundle();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $bundleproduct_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $bundleproduct_item=array(
            "BundleProductID" => $BundleProductID,
            "BundleId" => $BundleId,
            "ProductId" => $ProductId
        );
        array_push($bundleproduct_arr, $bundleproduct_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($bundleproduct_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("bundleproduct" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>