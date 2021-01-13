<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Returns request string
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            return trim($path, '/');
        }
        return null;
    }

    public function run()
    {
        // Получаем строку запроса
        $uri = $this->getURI();
        // Проверяем наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path)  {
            if(preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;
                //
                $controllerFile = ROOT.'/Controllers/'.$controllerName.'.php';
                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if ($result != null) {
                    break;
                }
            }
        }
    }
}