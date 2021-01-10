<?php
    
    require_once("/var/www/HomeBudget/php_classes/class_autoloader.php");

    // REQUIRE FILES
        require_once('env.php');
        require_once('private.php');
        require_once('configuration.php');
        require_once('database.php');
        require_once('utilities.php');
    //

    function check_db_connection() {
        $test_connection = new_mysqli();
        if($test_connection) {
            $success_message = 'Successfully established test connection to database';
            alert($success_message);
            write_log(DB_LOG, $success_message);
        }
        else {
            $failure_message = 'Failed to establish test connection to database. Terminating script.';
            write_log(DB_LOG, $failure_message);
            kill($failure_message);
        }
    }

    function new_mysqli($schema = null) {
        $host = get_db_host();
        $user = get_db_user();
        $password = get_db_password();
        if($schema = null) {
            $schema = get_db_schema();            
        }
        $mysqli = new mysqli($host, $user, $password, 'hook');
        return $mysqli;
    }

    function bind_params($query_params) {
        // bind_param('ss', 'hello', 'world');
    }

    function create_example_table() {
        $table  = array(
            'table_name' => 'example_table',
            'columns' => array(
                array(
                    'column_name' => 'id',
                    'column_data' => array(
                        'data_type' => 'INT',
                        'type_args' => array(
    
                        ),
                    ),
                    'column_attributes' => array(
                        'PK',
                        'AUTO_INCREMENT',
                    ),
                ),
                array(
                    'column_name' => 'total_price',
                    'column_data' => array(
                        'data_type' => 'DOUBLE',
                        'type_args' => array(
                            5,
                            2,
                        ),
                    ),
                    'column_attributes' => array(
                        'NOT NULL',
                    ),
                ),
            ),
        );

        $query_string_base = 'CREATE TABLE IF NOT EXISTS {{table_name}}({{table_args}});';
        $named_table_string = str_replace('{{table_name}}', $table['table_name'], $query_string_base);
        $columns = $table['columns'];
        $columns_string = '';
        for($x = 0; $x < sizeof($columns); $x++) {
            $column = $columns[$x];
            $column_definition_string = '';
            $column_definition_string .= $column['column_name'] . " ";
            $column_definition_string .= $column['column_data']['data_type'];
            if(sizeof($column['column_data']['type_args']) > 0) {
                $column_definition_string .= '(';
                for($i = 0; $i < sizeof($column['column_data']['type_args']); $i++) {
                    $column_definition_string .= $column['column_data']['type_args'][$i];
                    if ($i < sizeof($column['column_data']['type_args']) - 1) {
                        $column_definition_string .= ',';
                    }
                }
                $column_definition_string .= ')';
            }
            $columns_string .= $column_definition_string;
            if($x < sizeof($columns) - 1) {
                $columns_string .= ', ';
            }
        }
        $query_string = str_replace('{{table_args}}', $columns_string, $named_table_string);
        // die("QUERY STRING   >>>   " . $query_string);
        execute_query($query_string);
    }

    function drop_table($table_name = 'example_table') {
        $query = 'DROP TABLE IF EXISTS ';
        $query .= $table_name . ';';
        execute_query($query);
    }

    function execute_query($query) {
        $mysqli = new_mysqli();
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        end_dbc($query, $stmt, $mysqli);
    }

    function end_dbc($query, $stmt, $mysqli) {
        close_dbc($stmt, $mysqli);
        write_log(DB_LOG, "Executed Query -> [ $query ]");
    }

    function close_dbc($stmt, $mysqli) { 
        $stmt->close();
        $mysqli->close();
    }
    
?>