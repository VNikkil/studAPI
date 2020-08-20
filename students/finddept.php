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

$student->finddept();
  
if($student->name!=null){
    // create array
    $student_details = array(
        "rollno" =>  $student->rollno,
        "name" => $student->name,
        "dept" => $student->dept
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($student_details);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "No student in the database has this rollnumber"));
}
?>