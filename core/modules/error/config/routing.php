<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

$error = new RouterGroup([
    'module'    => 'error',
    'namespace' => 'Applcon\Error\Controllers',
]);

$error->addGet('/bad-request', 'Index::show400')
      ->setName('bad-request');

$error->addGet('/unauthorized', 'Index::show401')
      ->setName('unauthorized');

$error->addGet('/forbidden', 'Index::show403')
      ->setName('forbidden');

$error->addGet('/page-not-found', 'Index::show404')
    ->setName('page-not-found');

$error->addGet('/internal-error', 'Index::show500')
    ->setName('internal-error');

$error->addGet('/maintenance', 'Index::show503')
    ->setName('maintenance');

return $error;
