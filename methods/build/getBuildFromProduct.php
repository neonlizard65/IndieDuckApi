<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/build.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$build = new Build($db);
// чтение 
$build->ProductId = isset($_GET["ProductId"]) ? $_GET["ProductId"] : die(); 

$stmt = $build->getBuildFromProduct();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $build_arr=array();
    $build_arr["build"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $build_item=array(
            "BuildID" => $BuildID,
            "ProductId" => $ProductId,
            "DeveloperUserId" => $DeveloperUserId,
            "Version" => $Version,
            "Date" => $Date,
            "BuildContent" => $BuildContent
        );
        array_push($build_arr["build"], $build_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($build_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("build" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>