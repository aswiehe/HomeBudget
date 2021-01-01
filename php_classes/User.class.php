<?php

class User {

    public $username;
    public $new_password_one;
    public $new_password_two;
    public $mysqli;
    
    function __construct() {

    }

    function user_authentication_info($username, $password) {
        $authentication_info = array();
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_users');
        $query = 'SELECT user_id, username, password_hash FROM application_credentials WHERE username = ?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $authentication_info['user_id'] = $row['user_id'];
            $authentication_info['username'] = $row['username'];
            $authentication_info['password_hash'] = $row['password_hash'];
        }
        if($result->num_rows == 1) {
            if(password_verify($password, $authentication_info['password_hash'])) {
                $user_info = array();
                $user_info['user_id'] = $row['user_id'];
                $user_info['username'] = $row['username'];
                return $user_info;
            }
            else {
                return NULL;
            }
        }
        else {
            return NULL;
        }        
    }
    function new_passwords_match() {
        if($this->new_password_one == $this->new_password_two) {
            return true;
        }
        else {
            return false;
        }
    }
    function register_user() {
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_users');
        $query = "INSERT INTO application_credentials (username, password_hash) VALUES (?, ?)";
        if($this->new_password_one == $this->new_password_two) {
            $this->password_hash = password_hash($this->new_password_one, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ss', $this->username, $this->password_hash);
            $stmt->execute();
        }
    }
    function check_username_exists() {
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_users');
        $query = "SELECT user_id FROM application_credentials WHERE username = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $stmt->store_result();
        $num_rows_returned = $stmt->num_rows;
        $username_exists;
        if($num_rows_returned == 1) {
          $username_exists = true;
        }
        else if($num_rows_returned < 1){
          $username_exists = false;
        }
        else if($num_rows_returned > 1){
          die('MORE THAN one username like this already exists');
        }
        return $username_exists;
      }
      function authenticate($username, $password) {
        $authentication_info = array();
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('finfig_users');
        $query = 'SELECT user_id, username, password_hash FROM application_credentials WHERE username = ?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $authentication_info['user_id'] = $row['user_id'];
            $authentication_info['username'] = $row['username'];
            $authentication_info['password_hash'] = $row['password_hash'];
        }
        if($result->num_rows == 1) {
            if(password_verify($password, $authentication_info['password_hash'])) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            die('There are more than one users with this user id');
        }      

      }    

}

?>