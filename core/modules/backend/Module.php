<?php

namespace Applcon\Backend;

use Phalcon\Loader;
use Phalcon\DiInterface;
use Applcon\Common\Module as BaseModule;
use Applcon\Common\Library\Events\ViewListener;

/**
 * \Applcon\Backend\Module
 *
 * @package Applcon\Backend
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
        return 'Applcon\Backend\Controllers';
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
            'Applcon\Backend\Forms'      => __DIR__ . '/forms/',
        ];

        $loader->registerNamespaces($namespaces);

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
        $moduleConfig = require __DIR__ . '/config/config.php';

        // Tune Up the URL Component
        $url = $di->getShared('url');
        $url->setBaseUri($moduleConfig->application->baseUri);

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('view:notFoundView', new ViewListener($di));

        // Setting up the View Component
        $view = $di->getShared('view');
        $view->setViewsDir($moduleConfig->application->viewsDir);

        // @todo if structure received from db table instead getting from $config
        // we need to store it to cache for reducing db connections
        $configMenu = require __DIR__ . '/config/config.menu.php';

        $di->setShared(
            'menuStruct',
            function () use ($configMenu) {
                return $configMenu->get('menuStruct')->toArray();
            }
        );
    }
}
