<?php


class Admin
{
    // database connection and table name
    private $conn;
    private $table_name = "admins";

    //properties
    public $id;
    public $firstname;
    public $lastname;
    public $username;
    public $email;
    public $password;
    public $created_at;

    // constructor
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function create(){
        // creating date
        $date = date('Y-m-d H:i:s');


        // insert query
        $query = "INSERT INTO " . $this->table_name . "
            SET
                username = :username,
                password = :password,
                email = :email,
                firstname = :firstname,
                lastname = :lastname";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        //bindParams

        $stmt->bindParam("username",$this->username);
        $stmt->bindParam(":firstname",$this->firstname);
        $stmt->bindParam(":lastname",$this->lastname);
        $stmt->bindParam(":email",$this->email);
//        $stmt->bindParam(":created_at",$date);

        // Encrypt the password
        // hash the password before saving to database
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashed_password);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }



    function update($id){
        // updating date
        $date = date('Y-m-d H:i:s');

        //don't forget that

        // insert query
        $query = "";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize

        //bind params

        // hash the password before saving to database

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //delete function
    public function delete($name){
        //the id of the row we want to delete it
        //DELETE QUERY
        $query = "DELETE FROM " . $this->table_name . "
                WHERE 
                    id = :id";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        $id = $this->getIdByName($name);
        //bind param


        if($stmt->execute()){
            return true;
        }
        return false;
    }

    //getting id
    //getting id by username
    function getIdByUsername($username){

        //SELECT query
        $query = "SELECT id FROM " . $this->table_name . "
                WHERE username = :username";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind name param
        $stmt->bindParam(":username", $username);

        //execute the stmt
        $stmt->execute();

        //return the result
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['id'];
    }
}

