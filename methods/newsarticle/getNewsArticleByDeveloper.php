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
// чтение 
$newsarticle->DeveloperId = isset($_GET["DeveloperId"]) ? $_GET["DeveloperId"] : die(); 

$stmt = $newsarticle->getNewsArticleByDeveloper();
$rowcount =$stmt->rowCount();

// если есть записи
if($rowcount > 0){
    $newsarticle_arr=array();
    $newsarticle_arr["newsarticle"]=array();

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
        array_push($newsarticle_arr["newsarticle"], $newsarticle_item);
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
    echo json_encode(array("newsarticle" => "Группы не найдены."), JSON_UNESCAPED_UNICODE);
}
?>