
<?php


class Auth
{
    private $conn;
    private $admin_table = "admins";
    private $student_table = "students";
    private $choosed_table;

    //properties
    public $role;
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $email;
    public $class_id;

    // constructor
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function isExist($table){
        //query
//        switch ($role){
//            case 'admin':
//                $this->choosed_table = $this->admin_table;
//            case 'student':
//                $this->choosed_table = $this->student_table;
//        }
        $query = "SELECT * FROM " . $table . "
                WHERE
                    username = :username
                OR
                    email = :username
                ";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));

        //bindParams
        $stmt->bindParam(":username",$this->username);

        //execute the stmt
        if($stmt->execute()){
            return $stmt;
        }

        return false;
    }

}