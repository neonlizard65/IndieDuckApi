<?php

// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом review 
include_once '../../config/database.php';
include_once '../../models/review.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();
// подготовка объекта
$review = new Review($db);
// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));
// установим id свойства для редактирования 
$review->ReviewID = $data->ReviewID;

if(isset($review->ReviewID)){
    // устанавливаем значения свойств  

    $review->ProductId = $data->ProductId;
    $review->Rating = $data->Rating;
    $review->AuthorUserId = $data->AuthorUserId;
    $review->AuthorDevUserId = $data->AuthorDevUserId;
    $review->PostDate = $data->PostDate;
    $review->Header = $data->Header;
    $review->TextContent = $data->TextContent;
    

	// обновление товара
	if ($review->update()) {
	    // установим код ответа - 200 ok 
	    http_response_code(200);
	    // сообщим пользователю 
	    echo json_encode(array("message" => "Группа была обновлена."), JSON_UNESCAPED_UNICODE);
	}

	// если не удается обновить товар, сообщим пользователю 
	else {
	    // код ответа - 503 Сервис не доступен 
	    http_response_code(503);
	    // сообщение пользователю 
	    echo json_encode(array("message" => "Невозможно обновить группу."), JSON_UNESCAPED_UNICODE);
	}
}
else{
     http_response_code(404);
     echo "Введите индекс";
}
?>