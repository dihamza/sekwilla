<?php


/*
 * some test here
 */



// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

//require student class to instantiate an object
require_once '../../models/Marks.php';

//require Database class to get connect to database
require_once '../../config/Database.php';

//connection to database
$database = new Database();
$conn = $database->getConnection();


// instantiate product object
$mark = new Marks($conn);
$mark1 = '1';
$c = $mark->create($mark1);
if($c){

    // set response code
    http_response_code(200);
    echo $c;
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