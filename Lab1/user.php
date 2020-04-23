<?php
    require './interfaces/interface.php';
    require './interfaces/authenticate.php';
    require 'db.php';

    class User implements Crud,Authenticator{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;
        private $conn;
        private $username;
        private $password;

        function __construct($first_name,$last_name,$city_name,$username,$password){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
            $this->conn = new DBConnector;
            $this->username = $username;
            $this->password = $password;
        }

        public static function create(){
            $instance = new self();
            return $instance;
        }

        public function setUsername($username){
            $this->username = $username;
        }

        public function getUsername(){
            return $this->username;
        }

        public function setPassword($password){
            $this->password =$password;
        }

        public function getPassword(){
            return $this->password;
        }

        public function setUserId(){
            $this->user_id = $user_id;
        }

        public function getUserId(){
            return $this->user_id;
        }

        public function hashPassword(){
            $this->password = hash($this->password);
        }

        public function isPasswordCorrect(){
            $found = false;
            $res = $this->conn->conn->query("SELECT * FROM users");
            while($row = mysql_fetch_assoc($res)){
                $found = (password_verify($this->getPassword(),$row['password'])&& $this->getUsername() == $row['username']);
            }
            $this->conn->closeDatabase();
            return $found;
        }

        public function login(){
            if($this->isPasswordCorrect()){
                header("Location:private_page.php");
            }
        }

        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
        }

        public function logout(){
            session_start();
            unset($_SESSION['username']);
            session_destroy();
            header("Location:./index.php");
        }
        
        public function save(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $uname = $this->username;
            $this->hashPassword();
            $pass = $this->password;
            $sql = "INSERT INTO users (id,first_name,last_name,user_city,username,password) VALUES(DEFAULT,'".$fn."','".$ln."','".$city."','".$uname."','".$pass."')";
            if($this->conn->conn->query($sql)){
                // $this->conn->closeDatabase;
               return "saved";
            }else{
                echo($this->conn->conn->error."\n");
                // $this->conn->closeDatabase;
                return null;
            }
        }

        public function readAll(){
            $sqll = "SELECT * FROM users";
            $result = $this->conn->conn->query($sqll);
            return $result;
        }

        public function readUnique(){return null;}
        public function search(){return null;}
        public function update(){return null;}
        public function removeOne(){return null;}
        public function removeAll(){return null;}

        public function validateForm(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            
            return !($fn == "" || $ln == "" || $city =="");
        }

        public function createFormErrorSession(){
            session_start();
            $_SESSION['form_errors'] = "All Fields are required";
        }

    }
?>