<?php

namespace Examples\Signup;

use Examples\Signup\Mysqli;

class Application extends Base
{
    public function __construct(array $config)
    {
        self::$config = $config;
        self::$db = new Mysqli($config['db']);
    }
    
    public function handle(array $route)
    {
        $class = "Examples\\Signup\\Controller\\{$route['controller']}";
        if (class_exists($class)) {
            $controller = new $class();
            if (method_exists($controller, $route['method'])) {
                $controller->{$route['method']}($route['var']);
                exit();
            }
        }
        throw new \LogicException('Route not found');
    }
}
