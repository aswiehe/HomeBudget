<?php

    // REQUIRE FILES
        require_once('env.php');
        require_once('private.php');
        require_once('configuration.php');
        require_once('database.php');
        require_once('utilities.php');
    //

    if(session_status() != 2) {
        session_start();
    }

    function preprint($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    
    // function get_config() {
    //     $config_object = unserialize($_SESSION['state']['config']);
    //     return $config_object;
    // }
    // function configure_from_scratch() {
    //     $session_object = unserialize($_SESSION['state']['config']);
    //     $session_object->configure_from_scratch();
    // }
    // function show_config() {
    //     $session_object = unserialize($_SESSION['state']['config']);
    //     preprint($session_object);
    // }
    // function clear_logs() {;
    //     $session_object = unserialize($_SESSION['state']['config']);
    //     $session_object->clear_all_logs();
    // }
    // function reset_session() {
    //     session_destroy();
    //     $session_object = unserialize($_SESSION['state']['config']);
    //     $webapp_address = $session_object->get_webapp_address();
    //     echo "<script>window.location = '" . $webapp_address . "'</script>";
    // }
    // function check_db_connection() {
    //     attach('functions/db.php');
    //     test_db_connection();
    // }
    // function get_file_path($path_from_root) {
    //     $config_object = get_config();
    //     $root = $config_object->get_root();
    //     $file_path = $root . $path_from_root;
    //     return $file_path;
    // }
    // function attach($path_from_root, $attachment_method = 'require_once') {
    //     $file_path = get_file_path($path_from_root);
    //     $attachment_successful = null;
    //     switch($attachment_method) {
    //         case 'require_once': 
    //             $attachment_successful = require_once($file_path);
    //             break;
    //         case 'require': 
    //             $attachment_successful = require($file_path);
    //             break;
    //         case 'include_once': 
    //             $attachment_successful = include_once($file_path);
    //             break;
    //         case 'include': 
    //             $attachment_successful = include($file_path);
    //             break;
    //         default:
    //             $config_object = get_config();
    //             $config_object->log_new('errors.log', 'Attempting to attach another file using an unrecognized attachment method');
    //             break;
    //     }
    //     return $attachment_successful;
    // }



?>