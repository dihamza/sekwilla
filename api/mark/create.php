<?php

// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require user subject to call getIdByUsername (static)
require_once '../../models/subject.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

// instantiate product object
$mark = new Mark($conn);

// get posted data
// set product property values
$data = json_decode(file_get_contents("php://input"), TRUE);
var_dump($data);
$insertIn = $data['insertIn'];
$mark->mark = $data['mark'];
$mark->subject_id = $data['subject_id'];
$mark->student_id = $data['student_id'];
$res = false;

switch ($insertIn){
    case "mark1":
        $res = $mark->create();
        break;
    case "mark2":
        $res = $mark->updateMark2();
        break;
    case "mark3":
        $res = $mark->updateMark3();
        break;
    case "mark4":
        $res = $mark->updateMark4();
        break;
    case "mark5":
        $res = $mark->updateMark5();
        break;
}

// use the create() method here
// create the admin
if(
    !empty($mark->subject_id) &&
    !empty($mark->student_id) &&
    !empty($mark->mark) &&
    $res
){

    // set response code
    http_response_code(200);

    // display message: admin was created
    echo json_encode(array("message" => "Mark was created."));
}

// message if unable to create admin
else{

    // set response code
    http_response_code(400);

    // display message: unable to create admin
    echo json_encode(array("message" => "Unable to create Mark."));
}
?>
