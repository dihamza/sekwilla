<?php
// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//require student class to instantiate an object
require_once '../../models/student.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();


// instantiate product object
$student = new Student($conn);

// get posted data

$data = json_decode(file_get_contents("php://input"), TRUE);
//var_dump($data);

$student->firstname = $data['firstname'];
$student->lastname = $data['lastname'];
$student->username = $data['username'];
$student->email = $data['email'];
$student->password = $data['password'];
$student->class_id = $data['class_id'];
//$student->gender = $data['gender'];
//$student->birth = $data['birth'];


//use the create() method here

// create the admin
if(
    !empty($student->firstname) &&
    !empty($student->lastname) &&
    !empty($student->username) &&
    !empty($student->class_id) &&
    !empty($student->email) &&
    !empty($student->password) &&
    $student->create()
){

    // set response code
    http_response_code(200);

    // display message: admin was created
    echo json_encode(array("message" => "student was created."));
}

// message if unable to create admin
else{

    // set response code
    http_response_code(400);

    // display message: unable to create student
    echo json_encode(array("message" => "Unable to create Student."));
    }
?>
