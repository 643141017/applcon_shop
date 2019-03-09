<?php

namespace Applcon\Common;

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;

/**
 * \Applcon\Common\ModuleInterface
 *
 * @package Applcon\Common
 */
interface ModuleInterface extends ModuleDefinitionInterface, EventsAwareInterface
{
    /**
     * Initialize the module.
     */
    public function initialize();

    /**
     * Gets controllers/tasks namespace.
     *
     * @return string
     */
    public function getHandlersNamespace();
}
