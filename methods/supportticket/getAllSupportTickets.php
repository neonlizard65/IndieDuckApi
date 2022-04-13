<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/supportticket.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$supportticket = new SupportTicket($db);
// чтение монитора
$stmt = $supportticket->getAllSupportTickets();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $supportticket_arr=array();
    $supportticket_arr["supporttickets"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $supportticket_item=array(
            "SupportTicketID" => $SupportTicketID,
            "UserId" => $UserId,
            "ProductId" => $ProductId,
            "Name" => $Name,
            "AdditionalInfo" => $AdditionalInfo,
            "IsResolved"=>$IsResolved
        );
        array_push($supportticket_arr["supporttickets"], $supportticket_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($supportticket_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>