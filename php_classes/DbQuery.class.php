<?php


class DbQuery {

    private $myqsli;
    public $sql_path = '../../mysql';
    public $database;
    public $table;
    public $columns = array();
    public $query_string = '';
    public $query_array = array();
    public $delimiter = ";";

    function __construct() {
        $conn = new DbConnection();
        $this->mysqli = $conn->get_connection();
    }

    function set_database($database) {
        $this->database = $database;
    }

    function set_single_query($single_query) {
        $this->query_string = $single_query;
    }

    function add_multi_query($additional_query) {
        array_push($this->query_array, $additional_query);
    }

    function clear_query_array() {
        $this->query_array = array();
    }

    function run_multi_query() {
        $mysqli = $this->mysqli;
        $delimiter = $this->delimiter;
        $query_array = $this->query_array;
        $stringified_multi_query = implode($delimiter, $query_array);
        mysqli_multi_query($myqsli, $stringified_multi_query);
    }

    function run_single_query($query) {
        $mysqli = $this->mysqli;
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
    }

    function run_sql_file($filename) {
        $conn = new DbConnection();
        $mysqli = $conn->get_connection();
        $file = "$this->sql_path/$filename.sql";
        $stringified_multi_query = file_get_contents($file);
        $mysqli->multi_query($stringified_multi_query);
    }

    function query_return($schema, $query, $binding_array) {
        $conn = new DbConnection();
        $mysqli = $conn->schema_connect($schema);
        $stmt = $mysqli->prepare($query);
        $datatypes_string = '';
        $bound_params = array();
        $count = 0;
        foreach($binding_array as $param => $datatype) {
            $datatypes_string .= $datatype;
            ++$count;
            $bound_params[] = $param;
        }
        switch(sizeof($bound_params)) {
            case 0:
                // This would mean there are no parameters to be bound
            break;
            case 1:
                $stmt->bind_param($datatypes_string, $bound_params[0]);
            break;
            case 2:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1]);
            break;
            case 3:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2]);
            break;
            case 4:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3]);
            break;
            case 5:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3], $bound_params[4]);
            break;
            case 6:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3], $bound_params[4], $bound_params[5]);
            break;
            case 7:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3], $bound_params[4], $bound_params[5], $bound_params[6]);
            break;
            case 8:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3], $bound_params[4], $bound_params[5], $bound_params[6], $bound_params[7]);
            break;
            case 9:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3], $bound_params[4], $bound_params[5], $bound_params[6], $bound_params[7], $bound_params[8]);
            break;
            case 10:
                $stmt->bind_param($datatypes_string, $bound_params[0], $bound_params[1], $bound_params[2], $bound_params[3], $bound_params[4], $bound_params[5], $bound_params[6], $bound_params[7], $bound_params[8], $bound_params[9]);
            break;
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $return_set = array();
        while($row = $result->fetch_assoc()) {
          $return_set[] = $row;
        }
        return $return_set;
    }

}

?>