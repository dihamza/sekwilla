<?php


class Subject
{
    // database connection and table name
    private $conn;
    private $table_name = "subjects";

    //properties
    public $id;
    public $name;
    public $class_id;
    public $created_at;
    public $updated_at;

    // constructor
    public function __construct($conn){
        $this->conn = $conn;
    }

    // here the implementation of create function
    public function create(){
        $date = date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO " . $this->table_name. "
                SET
                name = :name,
                class_id = :class_id,
                created_at = :created_at";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind params
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":class_id", $this->class_id);
        $stmt->bindParam(":created_at", $date);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // here the implementation of update function
    public function update($name){

        // update query
        $query = "UPDATE " . $this->table_name . "
                SET
                    name = :name,
                    class_id = :class_id
                WHERE 
                    name = :nm";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind params
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":class_id", $this->class_id);

        $stmt->bindParam(":nm", $name);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // here the implementation of delete function
    public function delete($name){
        //the id of the row we want to delete it
        //DELETE QUERY
        $query = "DELETE FROM " . $this->table_name . "
                WHERE 
                    name = :name";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind param
        $stmt->bindParam(":name", $name);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    //getting id by name
    function getIdByName($name){

        //SELECT query
        $query = "SELECT id FROM " . $this->table_name . "
                WHERE name = :name";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind name param
        $stmt->bindParam(":name", $name);

        //execute the stmt
        $stmt->execute();
        if($stmt->rowCount() > 0){
            //return the result
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return json_encode($result);
        }
        return false;

    }

    //getting all exist subjects
    public function getSubjects(){
        //SELECT query
        $query = "SELECT id,name FROM " . $this->table_name;

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //execute the stmt
        $stmt->execute();

        //return the result
        return $stmt;
    }

    //getting subjects in a class
    public function getSubjectsInClass($class_id){
        //SELECT query
        $query = "SELECT id, name FROM " . $this->table_name ."
            WHERE 
                class_id = :class_id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $class_id = htmlspecialchars(strip_tags($class_id));

        //bind Params
        $stmt->bindParam(':class_id', $class_id);

        //execute the stmt
        $stmt->execute();

        //return the result
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get name by id function
    function getNameById($id){

        //SELECT query
        $query = "SELECT name FROM " . $this->table_name . "
                WHERE 
                    id = :id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind name param
        $stmt->bindParam(":id", $id);

        //execute the stmt
        $stmt->execute();
        if($stmt->rowCount() > 0){
            //return the result
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return json_encode($result);
        }
        return false;

    }
}