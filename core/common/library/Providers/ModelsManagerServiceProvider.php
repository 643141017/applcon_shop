<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Mvc\Model\Manager;

/**
 * \Applcon\Common\Library\Providers\ModelsManagerServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class ModelsManagerServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modelsManager';

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
                $modelsManager = new Manager();
                $modelsManager->setEventsManager($this->getShared('eventsManager'));

                return $modelsManager;
            }
        );
    }
}
