<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require subject class to instantiate objects
require_once '../../models/mark.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

//get subject instance here
$mark = new mark($conn);

//prepare posted data
$data = json_decode(file_get_contents("php://input"), TRUE);
$insertIn = $data['insertIn'];
$mark->mark = $data['mark'];
$mark->subject_id = $data['subject_id'];
$mark->student_id = $data['student_id'];
$res = false;

switch ($insertIn){
    case 'mark1':
        $res = $mark->updateMark1();
        break;
    case 'mark2':
        $res = $mark->updateMark2();
        break;
    case 'mark3':
        $res = $mark->updateMark3();
        break;
    case 'mark4':
        $res = $mark->updateMark4();
        break;
    case 'mark5':
        $res = $mark->updateMark5();
        break;
}


// use the update() method here
// update the subject
if(
    !empty($mark->mark) &&
    !empty($mark->subject_id) &&
    !empty($mark->student_id) &&
    $res
){

    // set response code
    http_response_code(200);

    // display message: Subject was updated.
    echo json_encode(array("message" => "Mark was updated."));
}

// message if unable to update subject
else{

    // set response code
    http_response_code(400);

    // display message: Unable to update Subject.
    echo json_encode(array("message" => "Unable to update Mark."));
}

