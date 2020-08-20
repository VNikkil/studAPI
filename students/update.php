<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'students.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$data = json_decode(file_get_contents("php://input"));

$student->rollno = $data->rollno;

$student->name = $data->name;
$student->dept = $data->dept;
$student->joined_year = $data->joined_year;
$student->curr_sem = $data->curr_sem;
$student->cgpa = $data->cgpa;

if($student->update()){
  
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message" => "the Student was updated."));
}
  
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update"));
}
?>