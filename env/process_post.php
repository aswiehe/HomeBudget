<?php

    // Enable error reporting by default
    if(!isset($_POST['report_errors'])) {
        $_POST['report_errors'] = true;
    }
    if($_POST['report_errors']) {
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        mysqli_report(MYSQLI_REPORT_ALL);
    }

    if(session_status() != 2) {
        session_start();
        require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/env.php');
    }

    // Log new POST
    write_log(ENV_LOG, PHP_EOL);
    write_log(ENV_LOG, 'PROCESSING NEW POST');

    // Load all classes from php_classes directory
    require_once(ROOT . "/php_classes/class_autoloader.php");    
    
    
    $processing_complete = false;
    $backup_counter = 0;
    while($processing_complete == false && $backup_counter != 20) {
        write_log(ENV_LOG, 'processing_complete is false, backup_counter != 20');
        $backup_counter++;
        if(isset($_POST['webapp_initialized'])) {
            write_log(ENV_LOG, '$_POST[\'webapp_initialized\'] was previously set');
            if($_POST['webapp_initialized']) {
                write_log(ENV_LOG, '$_POST[\'webapp_initialized\'] was previously set to true');
                write_log(ENV_LOG, 'Webapp successfully initialized');
                if(!isset($_POST['dashboard_items'])) {
                    $_POST['dashboard_items'] = array();
                }
                $dashboard_items = $_POST['dashboard_items'];
                process_dashboard_items($dashboard_items);
                $processing_complete = true;
            }
            else {
                write_log(ENV_LOG, '$_POST[\'webapp_initialized\'] was previously set to false');
                $_POST['webapp_initialized'] = initialize_webapp();
            }
        }
        else {
            write_log(ENV_LOG, '$_POST[\'webapp_initialized\'] was not previously set, but is now being set to false');
            $_POST['webapp_initialized'] = false;
        }
    }

    if($processing_complete == false) {
        $error_message = 'Webapp failed to initialize';
        write_log(ERROR_LOG, $error_message);
        kill($error_message);
    }
    else {
        $goto_page = $_SESSION['state']['navigation']['back_endpoint_path'];
        preprint($_SESSION);
        kill('goto page -> ' . $goto_page);
        write_log(ENV_LOG, 'Navigating to ' . $goto_page . ', then the post processing script will be finished');
        go_to_endpoint($goto_page);
    }
    
    return;
    
    function initialize_webapp() {     
        configure_state(null);
        return true;
    }

    function configure_state($state = null) {
        if($state == null) {    
        
            // The associative array below is the "template" for managing the sessions state as this file is called at the beginning of each page
            
            $state = array(
                'dashboard_items' => array(
                    'configure_from_scratch' => false,
                    'show_config' => false,
                    'clear_logs' => false,
                    'reset_session' => false,
                    'check_db_connection' => false,
                ),
                'navigation' => array(
                    'front_endpoint_path' => null,
                    'back_endpoint_path' => null,
                    'form_submit' => null,
                ),
                'user' => array(
                    'user_id' => null,
                    'username' => null,
                    'password_hash' => null,
                    'authenticated' => false,
                    'role' => null,
                ),
            );
        }
        $_SESSION['state'] = $state;
    }

    function set_endpoints($front_endpoint, $back_endpoint) {
        $_SESSION['state']['navigation']['front_endpoint_path'] = $front_endpoint;
        $_SESSION['state']['navigation']['front_endpoint_path'] = $back_endpoint;
    }
    
    function process_dashboard_items($dashboard_items) {
        // Handle actions to be done before processing post request
        $dashboard_item_options = array(
            'configure_from_scratch',
            'show_config',
            'clear_logs',
            'reset_session',
            'check_db_connection'
        );
        foreach($dashboard_items as $dashboard_item) {
            switch($dashboard_item) {
                case $dashboard_item_options[0]: configure_from_scratch();
                    break;
                case $dashboard_item_options[1]: show_config();
                    break;
                case $dashboard_item_options[2]: clear_all_logs();
                    break;
                case $dashboard_item_options[3]: reset_session();
                    break;
                case $dashboard_item_options[4]: check_db_connection();
                    break;
                default: // Do nothing
                    break;
            }
        }
    }

    function go_to_endpoint($endpoint_path) {
        echo "<script>window.location = '" . $endpoint_path . "'</script>";
    }
    
    function go_to_login() {
        
    }

?> 