<?php

    function nudge_private_script() {
        return 'You have nudged the private script, and this sentence is your response';
    }

    
    function get_db_host() {
        // $db_host = 'my_databse_host';
        $db_host = 'localhost';
        return $db_host;
    }

    function get_db_user() {
        // $db_user = 'my_database_user';
        $db_user = 'webapp';
        return $db_user;
    }

    function get_db_password() {
        // $db_password = 'my_database_password';
        $db_password = 'b3@nC0wnTr';
        return $db_password;
    }

    function get_db_schema() {
        // $db_schema = 'my_database_schema';
        $db_schema = 'generic_hook_db';
        return $db_schema;
    }

?>