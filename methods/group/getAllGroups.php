<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/group.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$group = new Group($db);
// чтение монитора
$stmt = $group->getAllGroups();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $group_arr=array();
    $group_arr["groups"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $group_item=array(
            "GroupID" => $GroupID,
            "GroupName" => $GroupName,
            "GroupImage" => $GroupImage,
            "GroupBio" => $GroupBio,
            "RolePostPrivelege" => $RolePostPrivelege
        );
        array_push($group_arr["groups"], $group_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($group_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что группы не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>