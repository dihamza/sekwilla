<?php

/*
 * some test here
 */

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
echo $subject->getIdByName('physiqu');