<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


include_once 'students.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
$student = new Student($db);
  
 //to check whether the client called this url with the rollno ..
$student->rollno = isset($_GET['rollno']) ? $_GET['rollno'] : die();      

if($student->delete())
{
    http_response_code(200);
    echo json_encode(array("message" => "The student details are deleted from the database"));
}

else{
    http_response_code(404);
    echo json_encode(array("message" => "No Student in the db with that rollnumber"));
}

?>

