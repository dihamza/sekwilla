<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require subject class to instantiate objects
require_once '../../models/class_.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$class = new Class_($conn);

//prepare posted data
$data = json_decode(file_get_contents("php://input"), TRUE);

$toUpdate = $data['nameAmod'];
$class->name = $data['name'];

// use the update() method here
// update the subject
if(
    !empty($class->name) &&
    !empty($toUpdate) &&
    $class->update($toUpdate)
){

    // set response code
    http_response_code(200);

    // display message: Subject was updated.
    echo json_encode(array("message" => "Class was updated."));
}

// message if unable to update subject
else{

    // set response code
    http_response_code(400);

    // display message: Unable to update Subject.
    echo json_encode(array("message" => "Unable to update class."));
}

