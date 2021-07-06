<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require subject class to instantiate objects
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

$toUpdate = $data['nameAmod'];
$subject->class_id = $data['class_id'];
$subject->name = $data['name'];

// use the update() method here
// update the subject
if(
    !empty($subject->class_id) &&
    !empty($subject->name) &&
    $subject->update($toUpdate)
){

    // set response code
    http_response_code(200);

    // display message: Subject was updated.
    echo json_encode(array("message" => "Subject was updated."));
}

// message if unable to update subject
else{

    // set response code
    http_response_code(400);

    // display message: Unable to update Subject.
    echo json_encode(array("message" => "Unable to update Subject."));
}

