<?php

namespace Applcon\Error;

use Phalcon\Loader;
use Phalcon\DiInterface;
use Applcon\Common\Module as BaseModule;
use Applcon\Common\Library\Events\ViewListener;

/**
 * \Applcon\Error\Module
 *
 * @package Applcon\Error
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
        return 'Applcon\Error\Controllers';
    }

    /**
     * 注册与模块相关的自动装载器
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $namespaces = [
            $this->getHandlersNamespace() => __DIR__ . '/controllers/',
        ];

        $loader->registerNamespaces($namespaces, true);

        $loader->register();
    }

    /**
     * 注册与模块相关的服务
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        // 读取配置
        $moduleConfig = require __DIR__ . '/config/config.php';

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('view:notFoundView', new ViewListener($di));

        // 设置视图组件
        $view = $di->getShared('view');
        $view->setViewsDir($moduleConfig['viewsDir']);
    }
}
