<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/ost.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$ost = new OST($db);

// установим свойство ID записи для чтения 
$ost->OSTID = isset($_GET['OSTID']) ? $_GET['OSTID'] : die();

// прочитаем детали разраба для редактирования 
$ost->getOSTByID();

// если есть ID
if ($ost->OSTID != null) {

    // создание массива 
    $ost_arr = array(
        "OSTID" => $ost->OSTID,
        "GameId" => $ost->GameId,
        "Composer" => $ost->Composer,
        "Artist" => $ost->Artist,
        "Name" =>  $ost->Name,
        "ReleaseDate" =>  $ost->ReleaseDate,
        "DeveloperId" =>  $ost->DeveloperId,
        "PublisherId" =>  $ost->PublisherId,
        "Discount" => $ost->Discount,
        "ShortBio" =>  $ost->ShortBio,
        "About" =>  $ost->About,
        "FranchiseId" =>  $ost->FranchiseId,
        "FranchiseName" =>  $ost->FranchiseName,
        "AgeRatingESRB" =>  $ost->AgeRatingESRB
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($ost_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>