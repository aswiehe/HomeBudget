<?php

class DbUser {

    private $username;
    private $password;
    private $schema = 'generic_hook_db';
    private $host = 'localhost';
    
    function __construct() {

    }

    function create_user($username, $password) {
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect('generic_hook_db');
        $query = "CREATE USER '" . $username . "'@'" . $this->host . "' IDENTIFIED BY '" . $password . "';";
        die($query);
        // Die and do NOT proceed with the code below until the above is tested
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    }

    function create_initial_users() {
        $initial_users = array(
            'web application' => array(
                'username' => 'webapp',
                'password' => '@pl!ca+i0nC0nc3ntr@tion'
            ),
            'accounting administrator' => array(
                'username' => 'accounting_admin',
                'password' => 'm3g@M0n!sCowntR'
            )
        );
        foreach($initial_users as $initial_user) {
            $this->create_user($initial_user['username'], $initial_user['password']);
        }
    }
}

?>