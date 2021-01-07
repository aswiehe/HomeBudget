<?php

    error_reporting(E_ALL);
    ini_set('display_errors',1);
    mysqli_report(MYSQLI_REPORT_ALL);
    require_once('env/process_post.php');
    
    write_log(MASTER_LOG, 'Program completed successfully');

    // create_table();
    drop_table();

    kill('Program complete');
    
    // die("<script>alert('Program completed successfully')</script>");
    // if(session_status() != 2) {
    //     session_start();
    // }
    // // session_destroy(); die('Session has been destroyed');

    // $_POST['dashboard_items'] = array(
    //     // 'clear_logs'
    //     'check_db_connection'
    //     // 'reset_session'
    // );

    // session_destroy();
    
    die('Milestone 1');
    // Create and serialize config object, then store in POST
    require_once("./php_classes/class_autoloader.php");
    $config = new Config();
    $config->configure_from_scratch();
    die('Milestone 2');
    $config->log_new('env.log', "Config object created");
    $config->attach('/functions/db.php');
    echo test_db_connection();

    $db_functions_attachment_message = null;
    if($config->dbc()) {
        $db_functions_attachment_message = 'Successfully attached database functions script';
    }
    else {
        $db_functions_attachment_message = 'Failed to attach database functions script';
    }
    $config->log_new('env.log', $db_functions_attachment_message);

?> 