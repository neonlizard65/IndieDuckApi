<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/cdkey.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$cdkey = new CDKey($db);

// установим свойство ID записи для чтения 
$cdkey->CDKeyID = isset($_GET['CDKeyID']) ? $_GET['CDKeyID'] : die();

// прочитаем детали разраба для редактирования 
$cdkey->getCDKeyByID();

// если есть ID
if ($cdkey->ThreadID != null) {

    // создание массива 
    $cdkey_arr = array(
        "CDKeyID" => $cdkey->ThreadID,
        "ProductId" => $cdkey->ProductId,
        "Content" =>  $cdkey->Content,
        "IsRedeemed" =>  $cdkey->IsRedeemed
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($cdkey_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>