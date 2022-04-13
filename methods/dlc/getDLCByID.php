<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/dlc.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$dlc = new DLC($db);

// установим свойство ID записи для чтения 
$dlc->DLCID = isset($_GET['DLCID']) ? $_GET['DLCID'] : die();

// прочитаем детали разраба для редактирования 
$dlc->getDLCByID();

// если есть ID
if ($dlc->DLCID != null) {

    // создание массива 
    $dlc_arr = array(
        "DLCID" => $dlc->DLCID,
        "GameId" => $dlc->GameId,
        "Name" =>  $dlc->Name,
        "ReleaseDate" =>  $dlc->ReleaseDate,
        "DeveloperId" =>  $dlc->DeveloperId,
        "PublisherId" =>  $dlc->PublisherId,
        "Discount" => $dlc->Discount,
        "ShortBio" =>  $dlc->ShortBio,
        "About" =>  $dlc->About,
        "FranchiseId" =>  $dlc->FranchiseId,
        "FranchiseName" =>  $dlc->FranchiseName,
        "AgeRatingESRB" =>  $dlc->AgeRatingESRB
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($dlc_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>