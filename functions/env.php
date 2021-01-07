<?php

    // REQUIRE FILES
        require_once('env.php');
        require_once('private.php');
        require_once('configuration.php');
        require_once('database.php');
        require_once('utilities.php');
    //

    
    define_logs();

    function define_logs() {
        define('ROOT', $_SERVER['DOCUMENT_ROOT']);
        define('MASTER_LOG', ROOT . '/env/log_files/master.log');
        define('ENV_LOG', ROOT . '/env/log_files/env.log');
        define('ACCESS_LOG', ROOT . '/env/log_files/access.log');
        define('DB_LOG', ROOT . '/env/log_files/db.log');
        define('ERROR_LOG', ROOT . '/env/log_files/error.log');
        define('REPORT_LOG', ROOT . '/env/log_files/report.log');
    }

    function write_log($log_path, $message, $access_method = 'a') {
        $handle = fopen($log_path, $access_method);
        $timestamp = timestamp();
        $log_entry_opener = '[' . $timestamp . '] >>> ';
        $log_text = $log_entry_opener . $message . PHP_EOL;
        fwrite($handle, $log_text);
        fclose($handle);
    }

    function clear_log($log_file) {
        $write_successful  = write_log($log_file, '(This log file has been cleared)', 'w');
    }

    function clear_all_logs() {
        clear_log(ENV_LOG);
        clear_log(ACCESS_LOG);
        clear_log(DB_LOG);
        clear_log(ERROR_LOG);
        clear_log(REPORT_LOG);
        write_log(MASTER_LOG, '(Cleared all log files, including this one)', 'w');
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

    function timestamp() {
        /*  To be noted about date() format:
            The date format below matches MySQL DATETIME format, so we'll
            use that as the default. It is due to this reason of wanting a 
            default in the first place that we are making this a function
            in the first place
        */
        $timestamp = date("Y-m-d H:i:s");
        return $timestamp;
    }

?>