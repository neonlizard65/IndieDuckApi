<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/developer.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$developer = new Developer($db);

// установим свойство ID записи для чтения 
$developer->CountryId = isset($_GET['CountryId']) ? $_GET['CountryId'] : die();

// прочитаем
$stmt= $developer->getDeveloperByCountry();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $developer_arr=array();
    $developer_arr["developer"]=array();

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
        array_push($developer_arr["developer"], $developer_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($developer_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Разработчиков в данной страны нет."), JSON_UNESCAPED_UNICODE);
}
?>