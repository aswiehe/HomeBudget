<?php

class Config {

    private $root;
    private $log_directory;
    private $log_files;
    private $log_paths;
    private $master_log_file;
    private $log_file_permissions;
    private $db_host;
    private $db_user;
    private $db_psw;
    private $db_schema;
    private $webapp_address;
    
    function __construct() {

    }

    function speak() {
        return 'hello world';
    }

    function dbc() {
        // $mysqli = new mysqli($this->db_host, $this->db_user, $this->db_psw, $this->db_schema);
        $mysqli = new mysqli('localhost', 'webapp', 'b3@nC0wn+r', 'generic_hook_db');
        $db_connection_successful = attach("./functions/db.php");
        return $mysqli;
    }

    function configure_from_scratch() {
        
        error_reporting(E_ALL);
        ini_set('display_errors',1);

        $successful_master_write = $this->write_log($this->master_log_file, '(This log file has been created)');
        if(!$successful_master_write) {
            $die_message = 'Unable to write to master log. Check if ' . $this->log_directory . $this->master_log_file . ' already exists but with incorrect permissions. Retry after fixing permissions and ensuring information in log file can safely be written over. Terminating script.';
            die($die_message);
        }
        $logs_successfully_created = false;
        foreach($this->log_files as $log_file) { // Master log must be created last
            $log_path = $this->log_directory . $log_file;
            // $this->chmod_log($log_path);
            if($log_file != $this->master_log_file) {
                if(!$this->verify_log_file($log_file)) {
                    $logs_successfully_created = $this->write_log($log_file, '(This log file has been created)');
                    $master_log_file_message = 'Creating the following log file -> {{' . $this->log_directory . $log_file . '}}';
                    $this->log_new($this->master_log_file, $master_log_file_message);
                }
                else {
                    $this->chmod_log($log_path);
                    $log_message = 'The application is attempting to configure itself again from scratch. The log file ' . $log_file . ' already exists in the location the application defines where it should exist. Permissions have been changed as needed by application, and any previous data has been overwritten.';
                    $logs_successfully_created = $this->log_new($log_file, $log_message);
                }
            }
        }
        if($logs_successfully_created) {
            $this->log_new($this->master_log_file, 'All log files have successfully been created');
        }
        else {
            $this->log_new($this->master_log_file, 'There was an issue creating one or more log files');
        }
    }

    function chmod_log($log_path) {
        $successful_chmod = chmod($log_path, $this->log_file_permissions);
        return $successful_chmod;
    }

    function config_instantiation() {
        return 'Config object instantiated';
    }

    function verify_log_file($log_file) { // CHECK FILE PERMISSIONS!!! (if this function is giving unexpected problems)
        $log_file_verified = null;
        $verification_message_options = array(
            null,
            true,
            'Log file failed verification for an unknown reason',
            'Unable to append to the following log file (permissions changed for next time) -> {{}}',
            'Unable to locate the following log file -> ',
            'This application has not defined the following as a valid path with file name for a log file -> {{}}',
        );
        $verification_message = $verification_message_options[0];
        $log_path = $this->log_directory . $log_file;
        $log_paths = $this->log_paths;
        
        $log_paths = array(
            '/var/www/homebudget/env/log_files/master.log',
            '/var/www/homebudget/env/log_files/env.log',
            '/var/www/homebudget/env/log_files/access.log',
            '/var/www/homebudget/env/log_files/db.log',
            '/var/www/homebudget/env/log_files/debug.log',
            '/var/www/homebudget/env/log_files/errors.log',
            '/var/www/homebudget/env/log_files/logic.log'
        );
        // preprint($log_paths);
        $log_path = '/var/www/homebudget/env/log_files/env.log';
        if(in_array($log_path, $log_paths)) { // Log file was defined defined within the application -> continuing verification
            if(file_exists($log_path)) { // Log file was defined within the application, and exists at location provided -> continuing verification
                $handle = fopen($log_path, 'a');
                if($handle == true) { // Log file was defined within the application, and exists at location provided, and application is able to append (write) to it -> continue verification
                    $log_file_verified = true;
                    $writable = is_writable($log_path);
                    if($writable != false) { // Successfully wrote opener to log file
                        $log_file_verified = true;
                        $verification_message = $verification_message_options[1];
                    }
                    else { // Unable to write to log file and not caught by any other contingency plans
                        $log_file_verified = false;
                        $verification_message = $verification_message_options[2];
                    }
                    fclose($handle);
                }
                else { // Log file was defined within the application, and exists at location provided, but application is unable to append (write) to it
                    chmod($log_path, 0644);
                    $log_file_verified = false;
                    $verification_message = $verification_message_options[3] . '{{' . $log_path . '}}';
                }
            }
            else { // Log file was defined within the application, but does not exist at location provided
                $log_file_verified = false;
                $verification_message = $verification_message_options[4] . '{{' . $log_path . '}}';
            }
        }
        else { // This log file hasn't been defined within the application though it may exist
            $log_file_verified = false;
            die($log_path);
            die('$verification_message');
            $verification_message = $verification_message_options[5] . '{{' . $log_path . '}}';
        }


        if($log_file_verified) {
            return true;
        }
        else {
            if($log_file == $this->master_log_file) {
                $die_message = 'Attempted to verify the master log file named ' . $this->master_log_file . ', but verification failed. Since the file itself is the master log file, no entry will be logged for this error. The verification message is as follows -> ' . $verification_message;
                die($die_message);
            }
            else {
                $master_log_verified = $this->verify_log_file($this->master_log_file);
                $master_log_message = 'Verification of another log file failed. The verification message is as follows -> ' . $verification_message;
                $this->log_new($this->master_log_file, $master_log_message);
            }
            $die_message = 'Log verification failed. The verification message was logged in the master log file and is as follows -> ' . $verification_message . ' Terminating this script';
            // The return message below is redundant but will be left as a fail-safe in case of changes to other parts of this function
            return false;
        }
    }

    function log_new($log_file, $message) {
        $log_write_successful = false; // Will later be set to return value of fwrite(...)
        $log_file_verified = $this->verify_log_file($log_file);
        $master_write_successful = false; // Will later be set to return value of fwrite(...)
        $master_log_verified = $this->verify_log_file($this->master_log_file);
        if($log_file == $this->master_log_file && $log_file_verified && $master_log_verified) {
            $log_write_successful = $master_write_successful = $this->append_log($log_file, $message);
            return ($log_write_successful && $master_write_successful);
        }
        else if($log_file != $this->master_log_file && $log_file_verified && $master_log_verified) {
            $master_write_successful = $this->append_log($this->master_log_file, $message);
            $log_write_successful = $this->append_log($log_file, $message);
            return ($log_write_successful && $master_write_successful);
        }
        else {
            $this->kill();
            return false;
        }
        return false;
    }

    function edit_log($log_file, $access_method, $message) {
        $log_path = $this->log_directory . $log_file;
        $handle = fopen($log_path, $access_method);
        $timestamp = $this->timestamp();
        $log_entry_opener = '[' . $timestamp . '] >>> ';
        $log_text = $log_entry_opener . $message . PHP_EOL;
        $fwrite_successful = fwrite($handle, $log_text);
        fclose($handle);
        return $fwrite_successful;
    }

    function append_log($log_file, $message) {
        $edit_successful = $this->edit_log($log_file, 'a', $message);
        return $edit_successful;
    }

    function write_log($log_file, $message) {
        $edit_successful = $this->edit_log($log_file, 'w', $message);
        return $edit_successful;
    }

    function clear_log($log_file) {
        if($log_file != $this->master_log_file) {
            $write_successful = $this->write_log($log_file, '(This log file has been cleared)');
            if($write_successful) {
                $master_log_file_message = 'Cleared the following log file -> ' . $log_file;
                $append_successful = $this->append_log($this->master_log_file, $master_log_file_message);
            }
            else {
                $master_log_file_message = 'Failed to clear the following log file -> ' . $log_file;
                $append_successful = $this->append_log($this->master_log_file, $master_log_file_message);
            }
        }
        else {
            $write_successful = $this->write_log($log_file, '(Log file cleared)');
        }
    }

    function clear_all_logs() {
        foreach($this->log_files as $log_file) {
            $this->clear_log($log_file);
        }
        $this->write_log($this->master_log_file, '(Cleared all log files, including this one)');
    }

    function kill() { // We differentiate between kill and stop because the former stops execution with the php function die and the latter with the php function exit, (die terminates with an error but exit doesn't)
        $kill_message = '<hr>There was a catostraphic error. Please request assistance from administrator, or if possible, review application logs';
        die($kill_message);
    }

    function stop() { // We differentiate between kill and stop because the former stops execution with the php function die and the latter with the php function exit, (die terminates with an error but exit doesn't)
        $stop_message = 'Stopping as directed by application';
        exit($stop_message);
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

    // ACCESS METHODS

    function set_root($root) {$this->root = $root;}
    function get_root() {return $this->root;}
    
    function set_log_directory($log_directory) {$this->log_directory = $log_directory;}
    function get_log_directory() {return $this->log_directory;}
    
    function set_log_files($log_files) {$this->log_files = $log_files;}
    function get_log_files() {return $this->log_files;}
    
    function set_log_paths($log_paths) {$this->log_paths = $log_paths;}
    function get_log_paths() {return $this->log_paths;}
    
    function set_master_log_file($master_log_file) {$this->master_log_file = $master_log_file;}
    function get_master_log_file() {return $this->master_log_file;}
    
    function set_log_file_permissions($log_file_permissions) {$this->log_file_permissions = $log_file_permissions;}
    function get_log_file_permissions() {return $this->log_file_permissions;}
    
    function set_db_host($db_host) {$this->db_host = $db_host;}
    function get_db_host() {return $this->db_host;}
    
    function set_db_user($db_user) {$this->db_user = $db_user;}
    function get_db_user() {return $this->db_user;}
    
    function set_db_psw($db_psw) {$this->db_psw = $db_psw;}
    function get_db_psw() {return $this->db_psw;}
    
    function set_db_schema($db_schema) {$this->db_schema = $db_schema;}
    function get_db_schema() {return $this->db_schema;}

    function set_webapp_address($webapp_address) {$this->webapp_address = $webapp_address;}
    function get_webapp_address() {return $this->webapp_address;}

}

?>