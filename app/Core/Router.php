<?php 

namespace App\Core;

class Router {

    private $Router ;

    public function add($url, $controller, $action) {
        $this->routes[$url] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($url) {
        if (array_key_exists($url, $this->routes)) {
            $controllerName = "App\\Controllers\\" . $this->routes[$url]['controller'];
            $action = $this->routes[$url]['action'];

            $controller = new $controllerName();
            $controller->$action();
        } else {
            echo "404 - Page Not Found";
        }
    }
}

?>