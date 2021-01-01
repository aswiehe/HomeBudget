<?php

    require_once("./php_classes/class_autoloader.php");
    // $config = new Config();

    function test_db_connection() {
        global $config;
        $mysqli = $config->dbc();
        $query = "SELECT VERSION();";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $successful_connection = false;
        while($row = $result->fetch_assoc()) {
          $version = $row['VERSION()'];
          $successful_connection = true;
        }
        $config->log_new('db.log', 'MySQL test connection was successful');
        return $version;
    }

?>