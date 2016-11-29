<?php
namespace core;

class Dispatcher {

    private $controller;
    private $action;
    private $params;

    public function __construct($get)
    {
        $this->controller = (isset($get['controller']) && !empty($get['controller']) ? ucfirst($get['controller']) : 'Article') . 'Controller';
        $this->action     = isset($get['action']) && !empty($get['action']) ? $get['action'] : 'accueil';

        unset($get['controller']);
        unset($get['action']);

        $this->params     = $get;
    }

    public function dispatch()
    {
        $controller = "app\\controllers\\$this->controller";

        if (file_exists(str_replace('\\', DIRECTORY_SEPARATOR, $controller) . '.php'))
        {
            $controller = new $controller();
            $action     = $this->action;

            if (method_exists($controller, $action))
                $controller->$action($this->params);
            else
                die("Vous devez créer la méthode $action dans la classe " . get_class($controller));
        }
        else
            die('Le controller n\'existe pas. Vous devez créer le fichier ' .  str_replace('\\', DIRECTORY_SEPARATOR, $controller) . '.php');
    }

    public function toString()
    {
        return "Dispatcher[controller: $this->controller, action: $this->action, params: { " . implode($this->params) . " }]";
    }

}