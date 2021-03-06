<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require student class to instantiate objects
require_once '../../models/Subject.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$subject = new Subject($conn);

//prepare posted data
$data = json_decode(file_get_contents("php://input"), TRUE);

$subject->class_id = $data['class_id'];
$subject->name = $data['name'];


// use the create() method here
if(
    !empty($subject->class_id) &&
    !empty($subject->name) &&
    $subject->create()
){

    // set response code
    http_response_code(200);

    // display message: subject was created
    echo json_encode(array("message" => "subject was created."));
}

// message if unable to create subject
else{

    // set response code
    http_response_code(400);

    // display message: unable to create subject
    echo json_encode(array("message" => "Unable to create subject."));
}