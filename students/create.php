<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");  //It indicates how long the results of a preflight request can be cached
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //to let the server know which HTTP headers the client might send when the actual request is made.

include_once 'students.php';

$database = new Database();
$db = $database->getConnection();

$students = new Student($db);

$data = json_decode(file_get_contents("php://input")); //the data that client sends to the server

if( !empty($data->rollno) && !empty($data->name) && !empty($data->dept) && !empty($data->joined_year) &&
   !empty($data->curr_sem) && !empty($data->cgpa) )
   {

        $students->rollno = $data->rollno;
        $students->name = $data->name;
        $students->dept = $data->dept;
        $students->joined_year = $data->joined_year;
        $students->curr_sem = $data->curr_sem;
        $students->cgpa = $data->cgpa;

        if($students->create())
        {
            http_response_code(201);
            echo json_encode(array("message" => " the student details are successfully added in the database"));
        }

        else{

            http_response_code(503);
    
            echo json_encode(array("message" => "unable to upload the data in the database"));
        }
   }

   else{
       http_response_code(400);
       echo json_encode(array("message" => "fill all the details of the student"));
   }


?>