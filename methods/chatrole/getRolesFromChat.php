<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/chatrole.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$chatrole = new ChatRole($db);
// чтение 
$chatrole->ChatId = isset($_GET["ChatId"]) ? $_GET["ChatId"] : die(); 

$stmt = $chatrole->getRolesFromChat();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $chatrole_arr=array();
    $chatrole_arr["chatroles"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $chatrole_item=array(
            "ChatRoleID" => $ChatRoleID,
            "ChatId" => $ChatId,
            "RoleName" => $RoleName,
            "WritePrivelege" => $WritePrivelege,
            "ModPrivelege" => $ModPrivelege
        );
        array_push($chatrole_arr["chatroles"], $chatrole_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($chatrole_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>