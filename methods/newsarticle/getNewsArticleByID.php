<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/newsarticle.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$newsarticle = new NewsArticle($db);

// установим свойство ID записи для чтения 
$newsarticle->NewsArticleID = isset($_GET['NewsArticleID']) ? $_GET['NewsArticleID'] : die();

// прочитаем детали разраба для редактирования 
$newsarticle->getNewsArticleByID();

// если есть ID
if ($newsarticle->NewsArticleID != null) {

    // создание массива 
    $newsarticle_arr = array(
        "NewsArticleID" => $newsarticle->NewsArticleID,
        "DeveloperId"=>$newsarticle->DeveloperId,
        "PublisherId"=>$newsarticle->PublisherId,
        "ProductId" => $newsarticle->ProductId,
        "AuthorUserId" =>  $newsarticle->AuthorUserId,
        "AuthorDevUserId" =>  $newsarticle->AuthorDevUserId,
        "PostDate" =>  $newsarticle->PostDate,
        "Header" =>  $newsarticle->Header,
        "TextContent" => $newsarticle->TextContent
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($newsarticle_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>