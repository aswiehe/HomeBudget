<?php
class DbConnection {
    
    private $db_username;
    private $db_password;
    private $db_host;
    private $db_schema;

    function __construct() {
        require('../../head/config.php');
        $this->db_username = $DB_USERNAME;
        $this->db_password = $DB_PASSWORD;
        $this->db_host = $DB_HOST;
        $this->db_schema = $DB_SCHEMA;
    }

    function get_connection() {
        $mysqli_connection = new mysqli(
            $this->db_host,
            $this->db_username,
            $this->db_password,
            $this->db_schema
        );
        return $mysqli_connection;
    }

    function schema_connect($schema) {
        $this->db_schema = $schema;
        $mysqli_connection = new mysqli(
            $this->db_host,
            $this->db_username,
            $this->db_password,
            $this->db_schema
        );
        return $mysqli_connection;
    }

}
    
?>