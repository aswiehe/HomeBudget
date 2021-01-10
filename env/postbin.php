<?php

    enable_error_reporting();
    intitialize_session();
    require_critical_files();
    process_dashboard();

    function enable_error_reporting() {
        if(!isset($_POST['report_errors'])) {
            $_POST['report_errors'] = true;
        }
        if($_POST['report_errors']) {
            error_reporting(E_ALL);
            ini_set('display_errors',1);
            mysqli_report(MYSQLI_REPORT_ALL);
        }
    }

    function intitialize_session() {
         // If session hasn't been started...
        if(session_status() != 2) {

            // ... Then start session
            session_start();

            // If $_SESSION array doesn't have an element called 'state' (which itself should be an array) , then create it
            if(!isset($_SESSION['state'])) {
                $state = array(
                    'dashboard' => array(
                        'configure_from_scratch',
                        'show_config',
                        'show_global_arrays',
                        'clear_all_logs',
                        'reset_session',
                        'check_db_connection',
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
                        'groups' => array(
                            
                        ),
                    ),
                    'data' => array(

                    ),
                );
                $_SESSION['state'] = $state;
            }
        }

        // Else if the $_SESSION array does already have a 'state' array within it, put the $_POST data inside the 'data' array of the $_SESSION array
        else{
            $data = $_POST['data'];
            $_SESSION['state']['data'] = $data;
        }
    }

    function require_critical_files() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/functions/env.php');
        require_once(ROOT . "/php_classes/class_autoloader.php");    
    }

    function process_dashboard() {
        // Set the dashboard array to an empty array if it has not been set by the dashboard html form being loaded into the DOM of the the page that made this postbin request
        if(!isset($_POST['dashboard'])) {
            $_POST['dashboard'] = array();
        }

        // Check each element within the dashboard array passed in from post against the session's array of possible dashboard options, and if there is a match, process the dashboard item using the appropriate function
        foreach($_POST['dashboard'] as $dashboard_item) {

            // Log that we are making a new attempt to process dashboard item X
            write_log(REPORT_LOG, 'Attempting to process dashboard item "' .  $dashboard_item . '"');

            // Check the requested dashboard item against the dashboard item options, and call the appropriate function (or log that there was a problem recognizing the appropriate option for the dashboard item passed in from the form)
            switch($dashboard_item) {
                case $_SESSION['state']['dashboard'][0]: configure_from_scratch();
                    break;
                case $_SESSION['state']['dashboard'][1]: show_config();
                    break;
                case $_SESSION['state']['dashboard'][2]: show_global_arrays();
                    break;
                case $_SESSION['state']['dashboard'][3]: clear_all_logs();
                    break;
                case $_SESSION['state']['dashboard'][4]: reset_session();
                    break;
                case $_SESSION['state']['dashboard'][5]: check_db_connection();
                    break;
                default: write_log(ENV_LOG, 'Failed to process a dashboard item defined in the dashboard page as "' . $dashboard_item . '" and passed through the $_POST array, because it has not been declared in the session state dashboard array');
                    break;
            }

            // Log the successful completion of the dashboard item (THIS NEEDS MORE TESTING TO BE ACCURATE)
            write_log(REPORT_LOG, 'Successfully processed dashboard item "' .  $dashboard_item . '"');
        }
    }

?>