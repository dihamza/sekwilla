<?php


class Student
{
    private $conn;
    private $table_name = "students";

    //properties
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $email;
    public $class_id;
    public $gender;
    public $birth;
    public $created_at;
    public $updated_at;

    // constructor
    public function __construct($conn){
        $this->conn = $conn;
    }

    // creat function implementation
    public function create(){

        // query
        $query = 'INSERT INTO ' . $this->table_name . '
            SET
                username = :username,
                password = :password,
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                class_id = :class_id';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->class_id = htmlspecialchars(strip_tags($this->class_id));
//        $this->gender = htmlspecialchars(strip_tags($this->gender));
//        $this->birth = htmlspecialchars(strip_tags($this->birth));


        //bindParams
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":firstname",$this->firstname);
        $stmt->bindParam(":lastname",$this->lastname);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":class_id",$this->class_id);
//        $stmt->bindParam(":gender",$this->gender);
//        $stmt->bindParam(":birth",$this->birth);

        // Encrypt the password
        // hash the password before saving to database
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashed_password);

        //execute the stmt
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //update function
    public function update($username){

        //query
        $query = 'UPDATE ' . $this->table_name . '
            SET
                username = :username,
                password = :password,
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                class_id = :class_id
            WHERE
                username = :usern';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->class_id = htmlspecialchars(strip_tags($this->class_id));
//        $this->gender = htmlspecialchars(strip_tags($this->gender));
//        $this->birth = htmlspecialchars(strip_tags($this->birth));

        //bindParams
        $stmt->bindParam(":username",$this->username);
        $stmt->bindParam(":firstname",$this->firstname);
        $stmt->bindParam(":lastname",$this->lastname);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":class_id",$this->class_id);
//        $stmt->bindParam(":gender",$this->gender);
//        $stmt->bindParam(":birth",$this->birth);
        $stmt->bindParam(':usern',$username);

        // Encrypt the password
        // hash the password before saving to database
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashed_password);

        //execute the stmt
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete function implementation here
    public function delete($username){

        //query
        $query = 'DELETE FROM ' . $this->table_name . '
            WHERE
                username = ?';

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind param
        $stmt->bindParam(1, $username);

        if ($stmt->execute()) {
            return $stmt;
        }
            return false;
    }

//    static function getIdByUsername($username, $conn){
//
//        //SELECT query
//        $query = "SELECT id FROM students
//                WHERE
//                      username = :username";
//
//        //prepare the query
//        $stmt = $conn->prepare($query);
//
//        //bind name param
//        $stmt->bindParam(":username", $username);
//
//        //execute the stmt
//        $stmt->execute();
//        if($stmt->rowCount() > 0){
//            //return the result
//            $stmt->setFetchMode(PDO::FETCH_ASSOC);
//            $result = $stmt->fetchAll();
//            return $result;
//        }
//        return false;
//    }

    //read students infos from the table
    public function read(){

        //query
        $query = "SELECT id, username, email, firstname, lastname,class_id 
                    FROM " . $this->table_name;

        //prepare the stmt
        $stmt = $this->conn->prepare($query);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function isExist($username){
        //query
        $query = 'SELECT username FROM ' . $this->table_name . ' WHERE
                    username = :username';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':username', $username);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function getStudent(){

        //query
        $query = "SELECT id, username, email, firstname, lastname,class_id 
                        FROM " . $this->table_name . "
                    WHERE 
                        username = :username";

        //prepare the stmt
        $stmt = $this->conn->prepare($query);

        //bind Params
        $stmt->bindParam(':username', $this->username);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function getStudents()
    {

        //query
        $query = "SELECT id, username, email, firstname, lastname,class_id 
                        FROM " . $this->table_name;

        //prepare the stmt
        $stmt = $this->conn->prepare($query);
        
        //execute the stmt
        if ($stmt->execute()) {
            return $stmt;
        }
        return false;
    }

        public function getStudentsInClass(){

        //query
        $query = "SELECT id, username, email, firstname, lastname,class_id 
                    FROM " . $this->table_name ."
                    WHERE 
                        class_id = :class_id";

        //prepare the stmt
        $stmt = $this->conn->prepare($query);

        //bind Params
        $stmt->bindParam(':class_id', $this->class_id);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function getGenderInClass($m){

        //query
        $query = "SELECT id, username, email, firstname, lastname,class_id 
                    FROM " . $this->table_name ."
                    WHERE 
                        class_id = :class_id
                    AND
                        gender = :m";

        //prepare the stmt
        $stmt = $this->conn->prepare($query);

        //bind Params
        $stmt->bindParam(':class_id', $this->class_id);
        $stmt->bindParam(':m', $m);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }
        return false;
    }

    public function getClassIdByUsername($username){

        //query
        $query = "SELECT class_id FROM " . $this->table_name . "
            WHERE
                username = :username";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $username = htmlspecialchars(strip_tags($username));

        //bind Parameters
        $stmt->bindParam(':username', $username);

        //execute the query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getIdByUsername($username){

        //query
        $query = "SELECT id FROM " . $this->table_name . "
            WHERE
                username = :username";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $username = htmlspecialchars(strip_tags($username));

        //bind Parameters
        $stmt->bindParam(':username', $username);

        //execute the query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return false;
    }


}


