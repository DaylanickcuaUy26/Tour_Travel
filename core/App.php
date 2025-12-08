<?php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Determine controller
        $controllerName = 'HomeController';
        if (!empty($url[0])) {
            $controllerCandidate = ucwords($url[0]) . 'Controller';
            if (file_exists(APP . '/controllers/' . $controllerCandidate . '.php')) {
                $controllerName = $controllerCandidate;
                unset($url[0]);
            }
        }
        
        require_once APP . '/controllers/' . $controllerName . '.php';
        $this->controller = new $controllerName;

        // Determine method
        $methodName = 'index';
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $methodName = $url[1];
                unset($url[1]);
            }
        }
        $this->method = $methodName;


        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call the controller method with params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
