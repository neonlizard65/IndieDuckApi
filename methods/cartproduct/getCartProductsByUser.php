<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/cartproduct.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$cartproduct = new CartProduct($db);
// чтение 
$cartproduct->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $cartproduct->getCartProductsByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $cartproduct_arr=array();
    $cartproduct_arr["cartproduct"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $cartproduct_item=array(
            "CartProductID" => $CartProductID,
            "UserId" => $UserId,
            "ProductId" => $ProductId
        );
        array_push($cartproduct_arr["cartproduct"], $cartproduct_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($cartproduct_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("cartproduct" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>