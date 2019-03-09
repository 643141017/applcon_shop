<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

$frontend = new RouterGroup([
    'module'     => 'frontend',
    'controller' => 'index',
    'action'     => 'index',
    'namespace'  => 'Applcon\Frontend\Controllers',
]);

$frontend->add('/:controller/:action/:params', [
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

$frontend->add('/', [
    'controller' => 'index',
    'action'     => 'index',
]);

$frontend->add('/{router}', [
    'module'     => 'frontend',
    'controller' => 'router',
])->beforeMatch(function ($uri, $route){
    $uris = ['search','backend'];

    if ($uri == '/' || in_array(ltrim($uri, '/'), $uris)){
        return false;
    }
    return ! $this->getRequest()->isAjax();
});

return $frontend;
