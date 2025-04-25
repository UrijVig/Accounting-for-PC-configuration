<?php 
    class Route {
        public static function start(): void {
            $controllerName = "Main";
            $actionName = "index";
            
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = substr($uri, 1);
            
            if ($uri) {
                $parts = explode('/', $uri);
                $actionName = $parts[0];
                
                // Дополнительные параметры из URL
                $params = array_slice($parts, 1);
            }
            
            $controllerName = $controllerName . "Controller";
            $actionName = "action" . ucfirst($actionName);
            
            try {
                $controller = new $controllerName();
                
                if (method_exists($controller, $actionName)) {
                    // Передаем метод запроса и параметры
                    $controller->$actionName($_SERVER['REQUEST_METHOD'], $params ?? []);
                } else {
                    $controller->action404();
                }
            } catch (Throwable $e) {
                // Обработка ошибок
                (new MainController())->action500();
            }
        }
    }