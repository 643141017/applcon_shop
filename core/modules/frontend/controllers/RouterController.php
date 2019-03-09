<?php

namespace Applcon\Frontend\Controllers;

/**
 * Class RouterController
 * This class to router page
 *
 * @package Applcon\Frontend\Controllers
 */
class RouterController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

        $this->view->pick('page');
    }

    /**
     * indexAction function.
     */
    public function indexAction()
    {
        $router = $this->dispatcher->getParam('router');
        if (empty($router)) {
            $router = 'page';
        }

        $this->view->tab = $router;

        if (file_exists($this->applcon->getPageFile($router))) {
            return $this->view->pick('pages/' . $router);
        }

        return $this->view->pick('page');
    }
}
