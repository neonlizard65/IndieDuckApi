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
$developer->DeveloperID = isset($_GET['DeveloperID']) ? $_GET['DeveloperID'] : die();

// прочитаем детали разраба для редактирования 
$developer->getDeveloperByID();

// если есть ID
if ($developer->DeveloperID != null) {

    // создание массива 
    $developer_arr = array(
        "DeveloperID" => $developer->DeveloperID,
        "DeveloperName" => $developer->DeveloperName,
        "DeveloperLogo" => $developer->DeveloperLogo,
        "DeveloperCard" => $developer->DeveloperCard,
        "DeveloperYoutube" => $developer->DeveloperYoutube,
        "DeveloperTwitch" => $developer->DeveloperTwitch,
        "DeveloperTwitter" => $developer->DeveloperTwitter,
        "DeveloperBio" => $developer->DeveloperBio,
        "CountryId" => $developer->CountryId
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($developer_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Разработчиков по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>