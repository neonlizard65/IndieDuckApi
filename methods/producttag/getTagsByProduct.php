<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/producttag.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$producttag = new ProductTag($db);
// чтение 
$producttag->ProductId = isset($_GET["ProductId"]) ? $_GET["ProductId"] : die(); 

$stmt = $producttag->getTagByProduct();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $producttag_arr=array();
    $producttag_arr["producttags"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $producttag_item=array(
            "ProductTagID" => $ProductTagID,
            "ProductId" => $ProductId,
            "TagId" => $TagId
        );
        array_push($producttag_arr["producttags"], $producttag_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($producttag_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("producttag" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>