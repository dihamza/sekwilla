<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require student class to instantiate an object
require_once '../../models/mark.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$mark = new mark($conn);

//posted name to delete
$data = json_decode(file_get_contents("php://input"), TRUE);
var_dump($data);
$mark->subject_id = $data['subject_id'];
$mark->student_id = $data['student_id'];

// use the delete() method here
// delete subject
if($mark->delete()){
    // set response code
    http_response_code(200);

    // display message: subject was deleted
    echo json_encode(array("message" => "mark was Deleted."));
}

// message if unable to delete subject
else{

    // set response code
    http_response_code(400);

    // display message: unable to delete subject
    echo json_encode(array("message" => "Unable to delete the mark."));
}