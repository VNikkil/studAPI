<?php
include_once '../config/db_inc.php';



class Student{
    private $conn;
    public $rollno;
    public $name;
    public $dept;
    public $joined_year;
    public $curr_sem;
    public $cgpa;
    
    public function __construct($db){
        $this->conn = $db;
    }

    function read($keyword){
        $query = "SELECT rollno,name,dept,joined_year,curr_sem,cgpa FROM students WHERE rollno = ? OR name = ?";
        $stmt = $this->conn->prepare($query);
        //to prevent SQL injection
        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);

        $stmt->execute();
        return $stmt;
    }

    function create(){
  
        // query to insert record of the student
        $query = "INSERT INTO students SET
                    rollno=:rollno, name=:name, dept= :dept, joined_year=:joined_year,curr_sem=:curr_sem, cgpa=:cgpa";
      
        // prepare query
        $stmt = $this->conn->prepare($query);
      
        //binding param .....to prevent SQL injection
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":rollno", $this->rollno);
        $stmt->bindParam(":dept", $this->dept);
        $stmt->bindParam(":joined_year", $this->joined_year);
        $stmt->bindParam(":curr_sem",$this->curr_sem);
        $stmt->bindParam(":cgpa", $this->cgpa);
      

        if($stmt->execute()){
            return true;
        }
        return false;     
    }

    function finddept(){
        $query = "SELECT name,dept FROM students WHERE WHERE rollno = ? OR name = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rollno);     //to prevent SQL injection
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row["name"];
        $this->dept = $row["dept"];
    }
 
    function update(){
  

        $query = "UPDATE students
                SET
                    name = :name,
                    dept = :dept,
                    joined_year = :joined_year,
                    curr_sem = :curr_sem,
                    cgpa = :cgpa
                WHERE
                    rollno = :rollno";
      
    
        $stmt = $this->conn->prepare($query);
      

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":rollno", $this->rollno);
        $stmt->bindParam(":dept", $this->dept);
        $stmt->bindParam(":joined_year", $this->joined_year);
        $stmt->bindParam(":curr_sem",$this->curr_sem);
        $stmt->bindParam(":cgpa", $this->cgpa);
      

        if($stmt->execute()){
            return true;
        }
      
        return false;
    }

    function delete(){
        $query = "DELETE FROM students WHERE rollno = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rollno);     //to prevent SQL injection
        
        if($stmt->execute())
            return true;
          
        else
            return false;    

    }

    function search($keyword){

        $query = "SELECT rollno,name FROM students WHERE rollno LIKE ? OR name like ? LIMIT  5";
        $stmt = $this->conn->prepare($query);

        $keyword = "{$keyword}%";

        //to prevent SQL injection
        $stmt->bindParam(1, $keyword);
        $stmt->bindParam(2, $keyword);

        $stmt->execute();

        return $stmt;
    }

}

?>