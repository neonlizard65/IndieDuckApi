<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/userachievement.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$userachievement = new UserAchievement($db);
// чтение 
$userachievement->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 
$userachievement->ProductId = isset($_GET["ProductId"]) ? $_GET["ProductId"] : die(); 

$stmt = $userachievement->getUserAchievementsByUserProduct();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $userachievement_arr=array();
    $userachievement_arr["userachievement"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $userachievement_item=array(
            "UserAchievementID" => $UserAchievementID,
            "AchievementId" => $AchievementId,
            "UserId" => $UserId,
            "Date" => $Date
        );
        array_push($userachievement_arr["userachievement"], $userachievement_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($userachievement_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("userachievement" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>