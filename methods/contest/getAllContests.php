<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/contest.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$contest = new Contest($db);
// чтение монитора
$stmt = $contest->getAllContests();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $contest_arr=array();
    $contest_arr["contests"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $contest_item=array(
            "ContestID" => $ContestID,
            "ContestName" =>  $ContestName,
            "ContestImage" =>  $ContestImage,
            "StartDate" =>  $StartDate,
            "EndDate" =>  $EndDate,
            "DeveloperWinner" =>  $DeveloperWinner,
            "UserWinner" =>  $UserWinner,
            "UserXPReward" =>  $UserXPReward,
            "DevMoneyReward" =>  $DevMoneyReward,
            "ContestDescription" =>  $ContestDescription
        );
        array_push($contest_arr["contests"], $contest_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($contest_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>