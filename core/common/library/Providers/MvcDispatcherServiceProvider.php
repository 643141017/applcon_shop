<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Cli\Dispatcher as CliDi;
use Applcon\Common\Library\Events\AccessListener;
use Applcon\Common\Library\Mvc\Dispatcher as MvcDi;
use Applcon\Common\Library\Events\DispatcherListener;

/**
 * \Applcon\Common\Library\Providers\MvcDispatcherServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class MvcDispatcherServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'dispatcher';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                if (container('bootstrap')->getMode() == 'cli') {
                    $dispatcher = new CliDi();
                } else {
                    $dispatcher = new MvcDi();
                    container('eventsManager')->attach('dispatch:beforeDispatch', new AccessListener($this));
                }

                container('eventsManager')->attach('dispatch', new DispatcherListener($this));

                $dispatcher->setDI(container());
                $dispatcher->setEventsManager(container('eventsManager'));

                return $dispatcher;
            }
        );
    }
}
