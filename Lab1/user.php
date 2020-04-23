<?php
    require './interfaces/interface.php';
    require 'db.php';
    class User implements Crud{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;
        private $conn;

        function __construct($first_name,$last_name,$city_name){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
            $this->conn = new DBConnector;
        }

        public function setUserId(){
            $this->user_id = $user_id;
        }

        public function getUserId(){
            return $this->user_id;
        }

        public function save(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $sql = "INSERT INTO users (id,first_name,last_name,user_city) VALUES(DEFAULT,'".$fn."','".$ln."','".$city."')";
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
    }
?>