<?php

ini_set('display_errors', 'on');
error_reporting(-1);

session_start();

// Class autoload
require __DIR__.'/../../src/bootstrap.php';
spl_autoload_register(
    function ($class) {
        if (strpos($class, 'Examples\Signup\\') === 0) {
            $name = substr($class, strlen('Examples\Signup\\') - 1);
            require __DIR__.strtr($name, '\\', DIRECTORY_SEPARATOR) . '.php';
        }
    }
);

// Configuration
$config = require(__DIR__.'/../config/config.php');
        
// Build route
$defaults = ['home', 'index', ''];
list($route['controller'], $route['method'], $route['var']) = isset($_GET['route'])
    ? explode('/', $_GET['route']) + $defaults
    : $defaults;
// Translate home::do_smth to Home::doSmth
$route['controller'] = str_replace(['-', '_'], '', ucwords($route['controller']));
$route['method']     = str_replace(['-', '_'], '', ucwords($route['method']));
$route['method']{0}  = strtolower($route['method']{0});

(new \Examples\Signup\Application($config))->handle($route);
