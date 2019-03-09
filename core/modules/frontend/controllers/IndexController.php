<?php

namespace Applcon\Frontend\Controllers;

/**
 * Class IndexController
 * This class to index page
 *
 * @package Applcon\Frontend\Controllers
 */
class IndexController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->pick('index');
    }

    /**
     * indexAction function.
     */
    public function indexAction()
    {

    }
}
