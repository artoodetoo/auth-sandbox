<?php

use R2\Auth\Endpoint;
use R2\Auth\Storage\Session;

require __DIR__.'/../src/bootstrap.php';
$config = require(__DIR__.'/config/config.php');

$storage = new Session();
$ep = new Endpoint($config['auth'], $storage);
$ep->process();
