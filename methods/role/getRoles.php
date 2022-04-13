<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/role.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$role = new Role($db);
// чтение монитора
$stmt = $role->getRoles();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $role_arr=array();
    $role_arr["roles"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $role_item=array(
            "RoleID" => $RoleID,
            "RoleName" => $RoleName
        );
        array_push($role_arr["roles"], $role_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($role_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Роли не найдены."), JSON_UNESCAPED_UNICODE);
}
?>