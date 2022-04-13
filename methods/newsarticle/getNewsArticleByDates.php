<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../../config/database.php';
include_once '../../models/newsarticle.php';

// получаем соединение с базой данных

$database = new Database();

$db = $database->getConnection();

// инициализируем объект

$newsarticle = new NewsArticle($db);
// чтение монитора
$Date1 = isset($_GET['Date1']) ? $_GET['Date1'] : die();
$Date2 = isset($_GET['Date2']) ? $_GET['Date2'] : die();
$stmt = $newsarticle->getNewsArticleByDates($Date1, $Date2);
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $newsarticle_arr=array();
    $newsarticle_arr["newsarticles"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $newsarticle_item=array(
            "NewsArticleID" => $NewsArticleID,
            "DeveloperId"=>$DeveloperId,
            "PublisherId"=>$PublisherId,
            "ProductId" => $ProductId,
            "AuthorUserId" =>  $AuthorUserId,
            "AuthorDevUserId" =>  $AuthorDevUserId,
            "PostDate" =>  $PostDate,
            "Header" =>  $Header,
            "TextContent" => $TextContent
        );
        array_push($newsarticle_arr["newsarticles"], $newsarticle_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);
     // выводим данные о товаре в формате JSON 
    echo json_encode($newsarticle_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>