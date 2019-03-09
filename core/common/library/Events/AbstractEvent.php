<?php

namespace Applcon\Common\Library\Events;

use Phalcon\DiInterface;
use Phalcon\Di\Injectable;
use Applcon\Common\InjectableTrait;

/**
 * \Applcon\Common\Library\Events\AbstractEvent
 *
 * @property \Phalcon\Logger\AdapterInterface $logger
 *
 * @package Applcon\Common\Library\Events
 */
abstract class AbstractEvent extends Injectable
{
    use InjectableTrait;

    /**
     * AbstractEvent constructor.
     *
     * @param DiInterface|null $di
     */
    public function __construct(DiInterface $di = null)
    {
        if ($di) {
            $this->setDI($di);
        }

        $this->injectDependencies();
    }
}
