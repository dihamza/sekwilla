<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require student class to instantiate an object
require_once '../../models/student.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$student = new Student($conn);

//get posted data
$data = json_decode(file_get_contents("php://input"), TRUE);
$student->class_id = $data['class_id'];


//get the returned stmt
$stmt = $student->getStudentsInClass();

if($stmt->rowCount() > 0){

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();

    // set response code
    http_response_code(200);

    // return founded data
    echo json_encode($result);
} else{

    // set response code
    http_response_code(400);

    // display message: No data was founded
    echo json_encode(array("message" => "No data was founded"));
}
