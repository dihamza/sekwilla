<?php

// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

//require student class to instantiate an object
require_once '../../models/class_.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();


// instantiate product object
$class = new Class_($conn);

// get posted data

$data = json_decode(file_get_contents("php://input"), TRUE);
$class->name = $data['name'];

//use the create() method here
// create the admin
if(
    !empty($class->name) &&
    $class->create()
){

    // set response code
    http_response_code(200);

    // display message: admin was created
    echo json_encode(array("message" => "Class was created."));
}

// message if unable to create admin
else{

    // set response code
    http_response_code(400);

    // display message: unable to create admin
    echo json_encode(array("message" => "Unable to create Class."));
}
?>
