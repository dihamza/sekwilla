<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require student class to instantiate an object
require_once '../../models/class_.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$class = new Class_($conn);

//get the returned stmt
$stmt = $class->getClasses();

if($stmt->rowCount() > 0){

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    // set response code
    http_response_code(200);

    // return founded data
    echo json_encode($result);
}

// message if No data was founded
else{

    // set response code
    http_response_code(400);

    // display message: No data was founded
    echo json_encode(array("message" => "No data was founded"));
}
