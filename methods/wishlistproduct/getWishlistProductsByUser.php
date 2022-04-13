<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/wishlistproduct.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$wishlistproduct = new WishlistProduct($db);
// чтение 
$wishlistproduct->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $wishlistproduct->getWishlistProductsByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $wishlistproduct_arr=array();
    $wishlistproduct_arr["wishlistproduct"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $wishlistproduct_item=array(
            "WishlistProductID" => $WishlistProductID,
            "UserId" => $UserId,
            "ProductId" => $ProductId
        );
        array_push($wishlistproduct_arr["wishlistproduct"], $wishlistproduct_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($wishlistproduct_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("wishlistproduct" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>