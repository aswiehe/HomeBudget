<?php   
    require_once("./php_classes/class_autoloader.php");
    $config = new Config();
    // $config->configure_from_scratch();
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