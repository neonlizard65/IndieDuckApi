<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/groupuser.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$groupuser = new GroupUser($db);
// чтение 
$groupuser->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $groupuser->getGroupsByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $groupuser_arr=array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $groupuser_item=array(
            "GroupUserID" => $GroupUserID,
            "UserId" => $UserId,
            "GroupId" => $GroupId,
            "GroupRole" => $GroupRole
        );
        array_push($groupuser_arr, $groupuser_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($groupuser_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("groupuser" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>