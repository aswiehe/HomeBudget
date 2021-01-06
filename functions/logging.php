<?php

    function alert($message) {
        echo '<script>alert("' . $message . '")</script>';
    }
    
    function console($message) {
        echo '<script>console.log("' . $message . '")</script>';
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

?>