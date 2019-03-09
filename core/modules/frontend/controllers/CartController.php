<?php

namespace Applcon\Frontend\Controllers;

/**
 * Class CartController
 * This class to index page
 *
 * @package Applcon\Frontend\Controllers
 */
class CartController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->pick('cart');
    }

    /**
     * indexAction function.
     */
    public function indexAction()
    {

    }
}