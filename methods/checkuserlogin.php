<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение базы данных и файл, содержащий объекты 
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT COUNT(UserName) FROM User WHERE UserName = :Login";
$stmt = $db->prepare($query);   
$stmt->bindValue(":Login", htmlspecialchars(strip_tags($_GET['UserName'])));
$stmt->execute();

if($stmt->rowCount() > 0){
    foreach ($stmt as $row) {
        echo $row[0];
    }
}
?>