<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/franchise.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$franchise = new Franchise($db);
// чтение монитора
$stmt = $franchise->getFranchises();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $franchise_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $franchise_item=array(
            "FranchiseID" => $FranchiseID,
            "FranchiseName" => $FranchiseName,
            "FranchiseImage" => $FranchiseImage
        );
        array_push($franchise_arr, $franchise_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($franchise_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>