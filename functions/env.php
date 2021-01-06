<?php

    define('ROOT', $_SERVER['DOCUMENT_ROOT']);
    initialize_logs();
    initialize_function_files();


    function initialize_logs() {
        $log_files = identify_logs();
        foreach($log_files as $log_file => $log_filepath) {
            attach($log_filepath);
        }
    }

    function initialize_function_files() {
        $functions_files = identify_functions_files();
        foreach($functions_files as $functions_file) {
            // attach($functions_file);
        }
        require_once('database.php');
        test_db_connection();
    }

    function identify_functions_files() {
        $functions_files_path = ROOT . '/functions/';
        $functions_filenames = array(
            'env.php',
            'configuration.php',
            'database.php',
            'utilities.php',
        );
        $functions_files_filepaths = array();
        foreach($functions_files_filepaths as $functions_files_filepath) {
            $functions_files_filepaths[$functions_files_filepath] = $functions_files_filepath . $functions_files_filepath;
        }
        return $functions_files_filepaths;
    }

    function identify_logs() {
        $log_path = ROOT . '/env/log_files/';
        $log_filenames = array(
            'master.log',
            'env.log',
            'access.log',
            'db.log',
            'error.log',
            'report.log',
        );
        $log_filepaths = array();
        foreach($log_filenames as $log_filename) {
            $underscored_filename = str_replace('.', '_', $log_filename);
            $capitalized_filename = strtoupper($underscored_filename);
            $filename_definition = $capitalized_filename;
            $log_filepaths[$filename_definition] = $log_path . $log_filename;
            // Define global log filenames as global variables for easier logging across files
            define($filename_definition, $log_filename);
        }
        return $log_filepaths;
    }

    function attach($file, $attachment_method = 'require_once') {
        switch($attachment_method) {
            case 'require_once': require_once($file);
                break;
            case 'include_once': include_once($file);
                break;
            case 'require': require($file);
                break;
            case 'include': include($file);
                break;
            case 'require_once': require_once($file);
                break;
            case 'require_once': require_once($file);
                break;
        }
    }

    function terminate($termination_message) {

    }

    function kill($message) {
        alert($message);
        die;
    }

    function stop($message) {
        console($message);
        die;
    }

    function alert($message) {
        $alert = '<script>alert("' . $message . '");</script>';
        echo $alert;
    }

    function console($message) {
        $console = '<script>console.log("' . $message . '");</script>';
        echo $console;
    }

?>