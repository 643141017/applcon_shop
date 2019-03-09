<?php

namespace Applcon\Controllers;

use Phalcon\Di\Injectable;
use Applcon\Common\InjectableTrait;
use Phalcon\Mvc\ControllerInterface;

/**
 * \Applcon\Controllers\AbstractController
 *
 * @package Applcon\Controllers
 */
abstract class AbstractController extends Injectable implements ControllerInterface
{
    use InjectableTrait;

    /**
     * AbstractController constructor.
     */
    final public function __construct()
    {
        if (method_exists($this, "onConstruct")) {
            $this->onConstruct();
        }

        $this->injectDependencies();
    }
}
