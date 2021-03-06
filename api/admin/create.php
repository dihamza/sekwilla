<?php

// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require user class to instantiate an object
require_once '../../models/Admin.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();

// instantiate product object
$user = new Admin($conn);

// get posted data
// set product property values
$data = json_decode(file_get_contents("php://input"), TRUE);

$user->firstname = $data['firstname'];
$user->lastname = $data['lastname'];
$user->username = $data['username'];
$user->email = $data['email'];
$user->password = $data['password'];

// use the create() method here
// create the admin
if(
    !empty($user->firstname) &&
    !empty($user->lastname) &&
    !empty($user->username) &&
    !empty($user->email) &&
    !empty($user->password) &&
    $user->create()
){

    // set response code
    http_response_code(200);

    // display message: admin was created
    echo json_encode(array("message" => "Admin was created."));
}

// message if unable to create admin
else{

    // set response code
    http_response_code(400);

    // display message: unable to create admin
    echo json_encode(array("message" => "Unable to create Admin."));
    }
?>
