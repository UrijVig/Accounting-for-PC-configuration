<?php 
    class Route{
        public static function start(): void
        {
            $controllerName = "Main";
            $actionName = "index";
            $uri = $_SERVER["REQUEST_URI"];
            $uri = substr($uri, 1);
            if ($uri) $actionName = $uri;

            $controllerName = $controllerName . "Controller";
            $actionName = "action" . $actionName;
            echo $actionName;
            $controller = new $controllerName();
            if (method_exists($controller, $actionName)) $controller->$actionName();
            else $controller->action404();
        }
    }