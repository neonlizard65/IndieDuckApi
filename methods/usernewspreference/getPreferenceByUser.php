<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/usernewspreference.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$usernewspreference = new UserNewsPreference($db);
// чтение 
$usernewspreference->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $usernewspreference->getPreferenceByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $usernewspreference_arr=array();
    $usernewspreference_arr["usernewspreferences"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $usernewspreference_item=array(
            "UserNewsPreferenceID" => $UserNewsPreferenceID,
            "UserId" => $UserId,
            "DeveloperId" => $DeveloperId,
            "PublisherId" => $PublisherId,
            "ProductId" => $ProductId
        );
        array_push($usernewspreference_arr["usernewspreferences"], $usernewspreference_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($usernewspreference_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("usernewspreference" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>