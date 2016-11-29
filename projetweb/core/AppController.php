<?php
namespace core;

session_start();

use core\helpers\Session;

class AppController {

    private $vars = [];
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function render($view, $layout = 'default')
    {
        if (!file_exists("app/views/layouts/$layout.html"))
            die("Le layout n'existe pas. Vous devez créer le fichier app/views/layouts/$layout.html");

        extract($this->vars);
        ob_start();

        $folder = str_replace('Controller', '', get_class($this));
        $folder = str_replace('controllers', 'views', $folder);
        $folder = str_replace('\\', DIRECTORY_SEPARATOR, $folder);
        $render = "$folder/$view.html";

        if (file_exists($render))
        {
            if (!isset($title_for_layout))
                $title_for_layout = str_replace('Controller', '', explode('\\', get_class($this))[2]);

            require $render;

            $content_for_layout = ob_get_clean();

            require "app/views/layouts/$layout.html";
        }
        else
            die("La vue n'existe pas. Vous devez créer le fichier $render");
    }

    public function set($vars)
    {
        $this->vars = array_merge($this->vars, $vars);
    }

    public function requireAuth()
    {
        if (!isset($_SESSION['Auth']))
            header('Location: ?controller=users&action=login');
    }

    public function loadModel()
    {
        $class     = str_replace('Controller', '', get_class($this));
        $class     = str_replace('controllers', 'models', $class);
        $modelFile = str_replace('\\', '/', $class) . '.php';
        $modelVar  = explode('\\', $class)[2];

        if (file_exists($modelFile))
            $this->$modelVar = new $class();
        else
            die("Le model n'existe pas. Vous devez créer le fichier $modelFile");
    }

    public function requestAction($controller, $action = 'index')
    {
        $controller = "\\app\\controllers\\$controller";
        $controller = new $controller();

        return $controller->$action();
    }

}