<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Events\Manager;

/**
 * \Applcon\Common\Library\Providers\EventManagerServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class EventManagerServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'eventsManager';

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
                /** @var \Phalcon\DiInterface $this */
                $em = new Manager();
                $em->enablePriorities(true);

                return $em;
            }
        );
    }
}
