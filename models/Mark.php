<?php


class Mark
{
    // database connection and table name
    private $conn;
    private $table_name = "marks";


    //properties
    public $id;
    public $student_id;
    public $subject_id;
    public $mark;

    // constructor
    public function __construct($conn){
        $this->conn = $conn;
    }

    //create function here
    public function create(){

        //query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                mark1 = :mark1,
                subject_id = :subject_id,
                student_id = :student_id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->mark = htmlspecialchars(strip_tags($this->mark));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(":mark1", $this->mark);
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //update function
    public function updateMark1(){

        //query
        $query = "UPDATE " . $this->table_name . "
            SET
                mark1 = :mark1
            WHERE
                subject_id = :subject_id 
            AND
                student_id = :student_id";
        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->mark = htmlspecialchars(strip_tags($this->mark));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':mark1', $this->mark);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function updateMark2(){

        //query
        $query = "UPDATE " . $this->table_name . "
            SET
                mark2 = :mark2
            WHERE
                subject_id = :subject_id 
            AND
                student_id = :student_id";
        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->mark = htmlspecialchars(strip_tags($this->mark));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':mark2', $this->mark);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function updateMark3(){

        //query
        $query = "UPDATE " . $this->table_name . "
            SET
                mark3 = :mark3
            WHERE
                subject_id = :subject_id 
            AND
                student_id = :student_id";
        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->mark = htmlspecialchars(strip_tags($this->mark));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':mark3', $this->mark);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function updateMark4(){

        //query
        $query = "UPDATE " . $this->table_name . "
            SET
                mark4 = :mark4
            WHERE
                subject_id = :subject_id 
            AND
                student_id = :student_id";
        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->mark = htmlspecialchars(strip_tags($this->mark));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':mark4', $this->mark);

        if($stmt->execute()){
            return true;
        }

        return false;
    }


    public function updateMark5(){

        //query
        $query = "UPDATE " . $this->table_name . "
            SET
                mark5 = :mark5
            WHERE
                subject_id = :subject_id 
            AND
                student_id = :student_id";
        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));
        $this->mark = htmlspecialchars(strip_tags($this->mark));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);
        $stmt->bindParam(':mark5', $this->mark);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //read function
    public function readStudentMarks(){

        //query
        $query = "SELECT mark1, mark2, mark3, mark4, mark5, coef FROM " . $this->table_name . "
            WHERE
                subject_id = :subject_id 
            AND
                student_id = :student_id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->student_id = htmlspecialchars(strip_tags($this->student_id));

        //bind parameters
        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':student_id', $this->student_id);

        if($stmt->execute()){
            return $stmt;
        }

        return false;
    }

    //delete function
    public function delete(){
        //the id of the row we want to delete it

        //DELETE QUERY
        $query = "DELETE FROM " . $this->table_name . "
                WHERE 
                    student_id = :student_id
                AND 
                    subject_id = :subject_id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind param
        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":student_id", $this->student_id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }



}