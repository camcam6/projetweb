<?php
namespace core;

class Autoloader {

    public static function register()
    {
        spl_autoload_register([ __CLASS__, 'autoload' ]);
    }

    public static function autoload($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        require_once "$class.php";
    }

}