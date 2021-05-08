<?php
    include_once 'include/config.php';
    include_once "include/filter_input_.php";
        
    spl_autoload_register(function ($class) {
        if (file_exists('cms/classes/' . $class . '.class.php')) {
            include_once 'cms/classes/' . $class . '.class.php';
        }
        else {
            include_once '../cms/classes/' . $class . '.class.php';
        }
    });

    $mysqli = new MyDB();
    $mysqli->get_db_instance();

    
?>