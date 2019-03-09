<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Mvc\View;
use Applcon\Common\Library\Events\ViewListener;

/**
 * \Applcon\Common\Library\Providers\ViewServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class ViewServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'view';

    protected $engines = [
        '.html' => 'volt',
        '.php'  => 'phpEngine',
    ];

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $registeredEngines = $this->engines;

        $this->di->setShared(
            $this->serviceName,
            function () use ($registeredEngines) {
                /** @var \Phalcon\DiInterface $this */
                $config = $this->getShared('config');

                $view = new View();

                $engines = [];
                foreach ($registeredEngines as $ext => $service) {
                    $engines[$ext] = $this->getShared($service, [$view, $this]);
                }

                $view->registerEngines($engines);
                $view->setViewsDir($config->application->view->viewsDir);
                $view->disableLevel([
                    View::LEVEL_MAIN_LAYOUT => true,
                    View::LEVEL_LAYOUT      => true,
                ]);

                $eventsManager = $this->getShared('eventsManager');
                $eventsManager->attach('view:notFoundView', new ViewListener($this));

                $view->setEventsManager($eventsManager);

                return $view;
            }
        );
    }
}
