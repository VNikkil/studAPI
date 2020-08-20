<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
include_once 'students.php';

$database = new Database();
$db = $database->getConnection();

$students = new Student($db);

$keyword=isset($_GET["search"]) ? $_GET["search"] : "";
$stmt = $students->search($keyword);
$num = $stmt->rowCount();

if($num>0){
  
    // products array
    $students_arr=array();
  
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
  
        $student_details=array(
            "rollno" => $rollno,
            "name" => $name,
        );
  
        array_push($students_arr, $student_details);
    }
  
     // set response code - 200 OK
     http_response_code(200);
  
     // show products data in json format
     echo json_encode($students_arr);

}

else{
 
   // 404 for Error
   http_response_code(404);
 
   echo json_encode(
       array("message" => "College is empty")
   );
}

?>