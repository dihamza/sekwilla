<?php


class Database
{
    //Db configurations
    private $host = 'localhost';
    private $db_name = 'sgepDatabase';
    private $user = 'root';
    private $password = 'root';
    private $conn;

    // connect to db
    public function getConnection() {

        try{

            // connecting to db using PDO
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->user, $this->password);

            // catch the exception
        } catch(PDOException $e){

            echo 'Failed: '.$e->getMessage();

        }
        return $this->conn;
    }
}