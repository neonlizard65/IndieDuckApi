<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/libraryitem.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$libraryitem = new LibraryItem($db);
// чтение 
$libraryitem->UserId = isset($_GET["UserId"]) ? $_GET["UserId"] : die(); 

$stmt = $libraryitem->getGamesFromUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $libraryitem_arr=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $libraryitem_item=array(
            "LibraryItemID" => $LibraryItemID,
            "UserId" => $UserId,
            "ProductId" => $ProductId,
            "Content" => $Content,
            "Hours" => $Hours
        );
        array_push($libraryitem_arr, $libraryitem_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($libraryitem_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("libraryitem" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>