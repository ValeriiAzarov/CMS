<?php

    spl_autoload_register(function ($class) {
        include_once 'classes/'.$class.'.class.php';
    });

    $mysqli = new MyDB();
    $mysqli->get_db_instance();
    

    /*spl_autoload_register(function ($class) {
        $inc_file = 'classes/' . $class . '.class.php';
        if (file_exists($inc_file)) {
            include_once $inc_file;
        }
        else if (file_exists("../" . $inc_file)) {
            include_once "../" . $inc_file;
        }
    });*/
