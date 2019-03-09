<?php


use Phalcon\Mvc\Router\Group as RouterGroup;

$oauth = new RouterGroup([
    'module'    => 'oauth',
    'namespace' => 'Applcon\Oauth\Controllers',
]);

$oauth->add('/oauth/:controller', [
    'controller' => 1,
]);

$oauth->add('/oauth/:controller/:action/:params', [
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

$oauth->add('/backend/reset-password', 'Register::resetpassword', ['GET', 'POST'])
      ->setName('resetpassword');

$oauth->add('/backend/forgot-password', 'Register::forgotpassword', ['GET', 'POST'])
      ->setName('forgotpassword');

$oauth->add('/backend/register', 'Register::index', ['GET', 'POST'])
    ->setName('register');

$oauth->add('/backend/signup', 'Register::signup', ['GET', 'POST'])
    ->setName('signup');

$oauth->add('/oauth/login', 'Login::index', ['GET', 'POST'])
      ->setName('login');

$oauth->addGet('/oauth/logout', 'Logout::index')
    ->setName('logout');

return $oauth;
