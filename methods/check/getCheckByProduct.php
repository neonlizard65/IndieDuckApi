<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/check.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$check = new Check($db);

// установим свойство ID записи для чтения 
$check->ProductId = isset($_GET['ProductId']) ? $_GET['ProductId'] : die();

// прочитаем
$stmt= $check->getCheckByProduct();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $check_arr=array();
    $check_arr["check"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $check_item=array(
            "CheckID" => $CheckID,
            "UserId" => $UserId,
            "UserCouponId" => $UserCouponId,
            "Total" => $Total,
            "IsGift" => $IsGift,
            "UserReceiverId" => $UserReceiverId,
            "IsRefunded" => $IsRefunded,
            "Date" => $Date
        );
        array_push($check_arr["check"], $check_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($check_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Разработчиков в данной страны нет."), JSON_UNESCAPED_UNICODE);
}
?>