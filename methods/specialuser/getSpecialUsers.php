<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/specialuser.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$specialuser = new SpecialUser($db);
// чтение монитора
$stmt = $specialuser->getSpecialUsers();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $specialuser_arr=array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $specialuser_item=array(
            "SpecialUserID" => $SpecialUserID,
            "Login" => $Login,
            "Pass" => $Pass,
            "RoleName" => $RoleName
        );
        array_push($specialuser_arr, $specialuser_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($specialuser_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>