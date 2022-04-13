<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/developer.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$developer = new Developer($db);
// чтение монитора
$stmt = $developer->getDevelopers();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $developer_arr=array();
    $developer_arr["developers"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $developer_item=array(
            "DeveloperID" => $DeveloperID,
            "DeveloperName" => $DeveloperName,
            "DeveloperLogo" => $DeveloperLogo,
            "DeveloperCard" => $DeveloperCard,
            "DeveloperYoutube" => $DeveloperYoutube,
            "DeveloperTwitch" => $DeveloperTwitch,
            "DeveloperTwitter" => $DeveloperTwitter,
            "DeveloperBio" => $DeveloperBio,
            "CountryId" => $CountryId

        );
        array_push($developer_arr["developers"], $developer_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($developer_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Разработчики не найдены."), JSON_UNESCAPED_UNICODE);
}
?>