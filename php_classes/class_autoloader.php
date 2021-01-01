<?php

    spl_autoload_register(function ($class_name) {
        $path_to_classes_from_autoloader = '';
        // include $path_to_classes_from_autoloader . $class_name . '.class' . '.php';
        include $path_to_classes_from_autoloader . $class_name . '.class' . '.php';
    });

    function get_class_info($class) {
        $class_name = get_class($class);
        $class_methods = get_class_methods($class);
        $obj_vars = get_object_vars($class);
        echo "<h1> [ $class_name ] </h1>";
        echo "<h3> Object Variables </h3>";
        foreach($obj_vars as $obj_var) {
            echo "<pre>";
            print_r($obj_var);
            echo "</pre>";
        }
        echo "<h3> Class Methods </h3>";
        foreach($class_methods as $class_method) {
            echo "<pre>";
            print_r($class_method);
            echo "</pre>";
        }
    }

?>