<?php

    if(session_status() != 2) {
        session_start();
        require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/env.php');
    }

    return;
    require_once("./php_classes/class_autoloader.php");    


    $processing_complete = false;
    $backup_counter = 0;

    while($processing_complete == false && $backup_counter != 20) {
        $backup_counter++;
        if(isset($_POST['webapp_initialized'])) {
            if($_POST['webapp_initialized']) {
                // Do any processing that must be done for ALL post requests
                $config_object = unserialize($_SESSION['state']['config']);
                $config_object->log_new('env.log', 'Webapp successfully initialized');
                $dashboard_items = $_POST['dashboard_items'];
                process_dashboard_items($dashboard_items);
                $processing_complete = true;
            }
            else {
                $_POST['webapp_initialized'] = initialize_webapp();
            }
        }
        else {
            $_POST['webapp_initialized'] = false;
        }
    }
    if($processing_complete == false) {
        $config_object->log_new('master.log', 'Webapp failed to initialize');
    }

    function initialize_webapp() {     
        
        // The associative array below is the "template" for managing the sessions state as this file is called at the beginning of each page
        $_SESSION['state'] = array(
            'config' => null,
            'resource_stack' => array(
                __FILE__
            ),
            'webapp_authentication' => array(
                'username' => null,
                'password_hash' => null,
                'authenticated' => false
            )
        );

        // Push serialized webapp configuration to session state array
        $serialized_config = include('config.php');
        $_SESSION['state']['config'] = $serialized_config;

        return true;
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
                case $dashboard_item_options[2]: clear_logs();
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

    // require_once("./php_classes/class_autoloader.php");
    // $serialized_objects = array();
    // $_POST['serialized_object'] = $serialized_objects;

    // $config_object = new Config();
    // array_push($serialized_objects, serialize($config_object));


    // $config->log_new('env.log', "Config object created");
    // $config->attach('/functions/db.php');
    // echo test_db_connection();

    // $db_functions_attachment_message = null;
    // if($config->dbc()) {
    //     $db_functions_attachment_message = 'Successfully attached database functions script';
    // }
    // else {
    //     $db_functions_attachment_message = 'Failed to attach database functions script';
    // }
    // $config->log_new('env.log', $db_functions_attachment_message);

?> 