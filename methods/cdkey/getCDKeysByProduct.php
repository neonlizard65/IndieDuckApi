<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/cdkey.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$cdkey = new CDKey($db);
// чтение 
$cdkey->ProductId = isset($_GET["ProductId"]) ? $_GET["ProductId"] : die(); 

$stmt = $cdkey->getCDKeysByProduct();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $cdkey_arr=array();
    $cdkey_arr["cdkeys"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $cdkey_item=array(
            "CDKeyID" => $CDKeyID,
            "Content" => $Content,
            "ProductId" => $ProductId,
            "IsRedeemed" => $IsRedeemed
        );
        array_push($cdkey_arr["cdkeys"], $cdkey_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($cdkey_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("cdkey" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>