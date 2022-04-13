<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/country.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$country = new Country($db);
// чтение монитора
$stmt = $country->getCountries();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $country_arr=array();
    $country_arr["countries"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $country_item=array(
            "CountryID" => $CountryID,
            "CountryName" => $CountryName,
            "CountryCode" => $CountryCode,
            "CountryFlag" => $CountryFlag
        );
        array_push($country_arr["countries"], $country_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($country_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Страны найдены."), JSON_UNESCAPED_UNICODE);
}
?>