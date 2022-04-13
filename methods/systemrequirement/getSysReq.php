<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../../config/database.php';
include_once '../../models/systemrequirement.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$systemrequirement = new SystemRequirement($db);

// установим свойство ID записи для чтения 
$systemrequirement->ProductId = isset($_GET['ProductId']) ? $_GET['ProductId'] : die();

// прочитаем детали разраба для редактирования 
$stmt=$systemrequirement->getSysReq();
$rowcount =$stmt->rowCount();


// если есть записи
if($rowcount > 0){
    $systemrequirement_arr=array();
    $systemrequirement_arr["systemrequirement"]=array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

          // создание массива 
        $systemrequirement_item = array(
            "SystemRequirementID" => $SystemRequirementID,
            "ProductId" =>  $ProductId,
            "Name" => $Name,
            "IsMinimumRecommended" => $IsMinimumRecommended,
            "OS" =>  $OS,
            "CPU" => $CPU,
            "RAM" =>  $RAM,
            "GPU" =>  $GPU,
            "DirectX" =>  $DirectX,
            "Storage" =>  $Storage,
            "SoundCard" =>  $SoundCard,
            "Network" =>  $Network,
            "AdditionalNotes" =>  $AdditionalNotes
        );
        array_push($systemrequirement_arr["systemrequirement"], $systemrequirement_item);
    }

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($systemrequirement_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Группы по данному индексу нет."), JSON_UNESCAPED_UNICODE);
}
?>