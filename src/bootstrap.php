<?php

mb_internal_encoding('UTF-8');

spl_autoload_register(function($class) {
    if (strpos($class, 'R2\Auth\\') === 0) {
        $name = substr($class, strlen('R2\Auth\\'));
        require __DIR__.strtr($name, '\\', DIRECTORY_SEPARATOR) . '.php';
    }
});
