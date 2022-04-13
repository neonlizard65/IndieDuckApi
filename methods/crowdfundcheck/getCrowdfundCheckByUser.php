<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/crowdfundcheck.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$crowdfundcheck = new CrowdfundCheck($db);

// установим свойство ID записи для чтения 
$crowdfundcheck->UserId = isset($_GET['UserId']) ? $_GET['UserId'] : die();

// прочитаем
$stmt= $crowdfundcheck->getCrowdfundCheckByUser();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $crowdfundcheck_arr=array();
    $crowdfundcheck_arr["crowdfundcheck"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $crowdfundcheck_item=array(
            "CrowdfundCheckID" => $CrowdfundCheckID,
            "UserId" => $UserId,
            "IsGift" => $IsGift,
            "UserReceiverId" => $UserReceiverId,
            "Sum" => $Sum,
            "Date" => $Date
        );
        array_push($crowdfundcheck_arr["crowdfundcheck"], $crowdfundcheck_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($crowdfundcheck_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Разработчиков в данной страны нет."), JSON_UNESCAPED_UNICODE);
}
?>