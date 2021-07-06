<?php


class Class_
{
    // database connection and table name
    private $conn;
    private $table_name = "classes";

    //properties
    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    // constructor
    public function __construct($conn){
        $this->conn = $conn;
    }

    //create class function here
    public function create(){
        //current date
        $date = date('Y-m-d H:i:s');

        //Query
        $query = 'INSERT INTO ' . $this->table_name.'
            SET
                name = :name
               ';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind parametres
        $stmt->bindParam(":name",$this->name);
//        $stmt->bindParam(":created_at",$date);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function update($name){
        //Query
        $query = 'UPDATE ' . $this->table_name . ' 
                SET
                    name = :name
                WHERE 
                    name = :nm';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind parametres
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":nm",$name);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    //delete class
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

    //get classes function
    public function getClasses(){
        //SELECT query
        $query = "SELECT name, id FROM " . $this->table_name;

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //execute the stmt
        $stmt->execute();

        //return the result
        return $stmt;
    }

    // get class by id
    public function getClassById($id){
        //SELECT query
        $query = "SELECT name FROM " . $this->table_name . "
                WHERE
                    id = $id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //execute the stmt
        $stmt->execute();

        //return the result
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}