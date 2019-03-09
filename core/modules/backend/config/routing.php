<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

$backend = new RouterGroup([
    'module'     => 'backend',
    'controller' => 'dashboard',
    'action'     => 'index',
    'namespace'  => 'Applcon\Backend\Controllers',
]);

$backend->add('/backend/:controller/:action/:params', [
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

$backend->add('/backend/:controller/:action', [
    'controller' => 1,
    'action'     => 2,
]);

$backend->add('/backend', [
    'controller' => 'dashboard',
    'action'     => 'index',
]);

return $backend;
