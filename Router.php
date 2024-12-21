<?php

class Router
{
    private static $routes = [];

    public static function addRoute($url, $controller = "Home", $action = "readBlogs")
    {
        self::$routes[$url] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    public static function run($url)
    {
        $url = trim($url, '/');
        $url = explode("?", $url)[0];
        
        if ($url == "database/setupDatabase") {
            self::runSetupScript();
            return;
        }
        
        if (array_key_exists($url, self::$routes)) {
            $route = self::$routes[$url];
            $controllerName = $route['controller'] . 'Controller';
            $controllerFile = ROOT_PATH . 'controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                if (class_exists($controllerName)) {
                    $controllerInstance = new $controllerName();

                    if (method_exists($controllerInstance, $route['action'])) {
                        $controllerInstance->{$route['action']}();
                    } else {
                        self::notFound("Action '{$route['action']}' not found in controller '$controllerName'");
                    }
                } else {
                    self::notFound("Controller class '$controllerName' not found");
                }
            } else {
                self::notFound("Controller file for '{$route['controller']}' not found");
            }
        } else {
            self::notFound();
        }
    }

    public static function notFound($message = 'Page not found')
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 - $message";
    }
    
    private static function runSetupScript()
    {
        $scriptFile = __DIR__ . "\database\setupDatabase.php";
        if (file_exists($scriptFile)) {
            require_once $scriptFile;
        } else {
            echo "Setup script not found.";
        }
    }
    
}
