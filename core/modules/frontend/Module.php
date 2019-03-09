<?php

namespace Applcon\Frontend;

use Phalcon\Loader;
use Phalcon\DiInterface;
use Applcon\Common\Module as BaseModule;
use Applcon\Common\Library\Events\ViewListener;

/**
 * \Applcon\Frontend\Module
 *
 * @package Applcon\Frontend
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
        return 'Applcon\Frontend\Controllers';
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
            'Applcon\Frontend\Forms'     => __DIR__ . '/forms/',
        ];

        $loader->registerNamespaces($namespaces);

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

        // 调整URL组件
        $url = $di->getShared('url');
        $url->setBaseUri($moduleConfig->application->baseUri);

        $eventsManager = $di->getShared('eventsManager');
        $eventsManager->attach('view:notFoundView', new ViewListener($di));

        // 设置视图组件
        $theme = $di->getShared('theme');
        $view = $di->getShared('view');
        $view->setViewsDir(themes_path($theme->getThemeName()));
    }
}
