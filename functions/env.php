<?php

    $log_files = define_logs();
    foreach($log_files as $log_file => $log_filepath) {
        attach($log_filepath);
    }

    function define_logs() {
        $log_path = '/var/www/HomeBudget/env/log_files/';
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

?>