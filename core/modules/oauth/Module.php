<?php

namespace Applcon\Oauth;

use Phalcon\Loader;
use Phalcon\DiInterface;
use Applcon\Common\Module as BaseModule;
use Applcon\Common\Library\Events\EmployeeLogin;
use Applcon\Common\Library\Events\ViewListener;

/**
 * \Applcon\Oauth\Module
 *
 * @package Applcon\Oauth
 */
class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getHandlersNamespace()
    {
        return 'Applcon\Oauth\Controllers';
    }

    /**
     * Registers an autoloader related to the module.
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $namespaces = [
            $this->getHandlersNamespace() => __DIR__ . '/controllers/',
            'Applcon\Oauth\Forms'        => __DIR__ . '/forms/',
        ];

        $loader->registerNamespaces($namespaces, true);

        $loader->register();
    }

    /**
     * Registers services related to the module.
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        // Read configuration
        $moduleConfig = require_once __DIR__ . '/config/config.php';

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('employee', new EmployeeLogin($di));

        // Tune Up the URL Component
        $url = $di->getShared('url');
        $url->setBaseUri($moduleConfig->application->baseUri);

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('view:notFoundView', new ViewListener($di));

        // Setting up the View Component
        $view = $di->getShared('view');
        $view->setViewsDir($moduleConfig->application->viewsDir);
    }
}
