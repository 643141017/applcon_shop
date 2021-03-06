<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Registry;
use RecursiveDirectoryIterator;
use Applcon\Cli\Module as Cli;
use Applcon\Oauth\Module as oAuth;
use Applcon\Error\Module as Error;
use Applcon\Backend\Module as Backend;
use Applcon\Frontend\Module as Frontend;
use Phalcon\Cli\Console as ConsoleApplication;
use Phalcon\Mvc\Application as MvcApplication;

/**
 * \Applcon\Common\Library\Providers\ModulesServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class ModulesServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modules';

    protected $modules = [];

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function configure()
    {
        $directory = new RecursiveDirectoryIterator(content_modules_path());

        foreach ($directory as $item) {
            $name = $item->getFilename();
            if (!$item->isDir() || $name[0] == '.') {
                continue;
            }

            $this->modules[$name] = [
                'className' => 'Applcon\\' . ucfirst($name) . '\\Module',
                'path'      => content_modules_path("{$name}/Module.php"),
                'router'    => content_modules_path("{$name}/config/routing.php"),
            ];
        }

        $core = [
            'error' => [
                'className' => Error::class,
                'path'      => modules_path('error/Module.php'),
                'router'    => modules_path('error/config/routing.php'),

            ],
            'frontend' => [
                'className' => Frontend::class,
                'path'      => modules_path('frontend/Module.php'),
                'router'    => modules_path('frontend/config/routing.php'),

            ],
            'oauth' => [
                'className' => oAuth::class,
                'path'      => modules_path('oauth/Module.php'),
                'router'    => modules_path('oauth/config/routing.php'),

            ],
            'backend' => [
                'className' => Backend::class,
                'path'      => modules_path('backend/Module.php'),
                'router'    => modules_path('backend/config/routing.php'),
            ],
            // 'cli' => [
            //     'className' => Cli::class,
            //     'path'      => modules_path('cli/Module.php'),
            //     'router'    => modules_path('cli/config/routing.php')
            // ],
        ];

        $this->modules = array_merge($core, $this->modules);
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $modules = $this->modules;

        $this->di->setShared(
            $this->serviceName,
            function () use ($modules) {
                $modulesRegistry = new Registry();

                foreach ($modules as $name => $module) {
                    $modulesRegistry->offsetSet($name, (object) $module);
                }

                return $modulesRegistry;
            }
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function boot()
    {
        $modules = [];

        foreach ($this->modules as $name => $module) {
            $modules[$name] = function () use ($module) {
                $moduleClass = $module['className'];
                if (!class_exists($moduleClass)) {
                    /** @noinspection PhpIncludeInspection */
                    include_once $module['path'];
                }

                /** @var \Applcon\Common\ModuleInterface $moduleBootstrap */
                $moduleBootstrap = new $moduleClass(container());

                $moduleBootstrap->initialize();

                return $moduleBootstrap;
            };

            $this->getDI()->setShared($module['className'], $modules[$name]);
        }

        /** @var MvcApplication|ConsoleApplication $application */
        $application = container('bootstrap')->getApplication();

        if ($application instanceof ConsoleApplication) {
            $application->registerModules($this->modules);
        } else {
            $application->registerModules($modules);
        }
    }
}
