<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/coupon.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$coupon = new Coupon($db);
// чтение монитора
$stmt = $coupon->getCoupons();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $coupon_arr=array();
    $coupon_arr["coupons"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $coupon_item=array(
            "CouponID" => $CouponID,
            "CouponName" => $CouponName,
            "DiscountPercent" => $DiscountPercent
        );
        array_push($coupon_arr["coupons"], $coupon_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($coupon_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Купоны не найдены."), JSON_UNESCAPED_UNICODE);
}
?>