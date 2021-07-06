<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require student class to instantiate an object
require_once '../../models/Subject.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$subject = new Subject($conn);

//posted name to delete
$data = json_decode(file_get_contents("php://input"), TRUE);
$toDelete = $data['name'];

// use the delete() method here
// delete subject
if($subject->delete($toDelete)){

    // set response code
    http_response_code(200);

    // display message: subject was deleted
    echo json_encode(array("message" => "subject was Deleted."));
}

// message if unable to delete subject
else{

    // set response code
    http_response_code(400);

    // display message: unable to delete subject
    echo json_encode(array("message" => "Unable to delete the subject."));
}