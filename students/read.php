<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once 'students.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$keyword=isset($_GET["search"]) ? $_GET["search"] : "";
$stmt = $student->read($keyword);
$num = $stmt->rowCount();

if($num > 0)
{
    $student_arr=array();
               
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){                                              
        // It imports variables into the local symbol table from an array.
        extract($row);
  
        $student_arr=array(
            "rollno" => $rollno,
            "name" => $name,
            "dept" => $dept,
            "joined_year" => $joined_year,
            "curr_sem" => $curr_sem,
            "cgpa" => $cgpa
        );
  

    }
      // set response code - 200 OK
      http_response_code(200);
  
      // show products data in json format
      echo json_encode($student_arr);

}

else{
  
    // 404 for Error
    http_response_code(404);
  
    echo json_encode(
        array("message" => "College is empty")
    );
}