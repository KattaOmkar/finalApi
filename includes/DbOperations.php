<?php 
    /*
        Author: Belal Khan
        Post: PHP Rest API Example using SLIM
    */

    class DbOperations{
        //the database connection variable
        private $con; 

        //inside constructor
        //we are getting the connection link
        function __construct(){
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect; 
            $this->con = $db->connect(); 
        }

        public function createSpend($date,$reason,$amount){
            $stmt = $this->con->prepare("INSERT INTO spending (date, reason, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("sss",$date,$reason,$amount);
            if($stmt->execute()){
                return Added;
            }
            else{
                return NotAdded;
            }
        }

        public function createReceive($date,$from_reason,$amount){
            $stmt = $this->con->prepare("INSERT INTO receiving (date, from_reason, amount) VALUES (?, ?, ?)");
            $stmt->bind_param("sss",$date,$from_reason,$amount);
            if($stmt->execute()){
                return Added;
            }
            else{
                return NotAdded;
            }
        }

        public function getAllSpends(){
            $stmt = $this->con->prepare("SELECT ID,date,reason,amount FROM spending;");
            $stmt->execute();
            $stmt->bind_result($id,$date,$reason,$amount);
            $spends = array();
            while($stmt->fetch()){
                $spend = array();
                $spend['ID'] = $id;
                $spend['date'] = $date;
                $spend['reason'] = $reason;
                $spend['amount'] = $amount;
                array_push($spends,$spend);

            }
            return $spends;
        }

        public function getAllReceives(){
            $stmt = $this->con->prepare("SELECT ID,date,from_reason,amount FROM receiving;");
            $stmt->execute();
            $stmt->bind_result($id,$date,$from_reason,$amount);
            $receives = array();
            while($stmt->fetch()){
                $receive = array();
                $receive['ID'] = $id;
                $receive['date'] = $date;
                $receive['from_reason'] = $from_reason;
                $receive['amount'] = $amount;
                array_push($receives,$receive);

            }
            return $receives;
        }
    }