<?php

namespace Applcon\Frontend\Controllers;

/**
 * Class CheckoutController
 * This class to index page
 *
 * @package Applcon\Frontend\Controllers
 */
class CheckoutController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->pick('checkout');
    }

    /**
     * indexAction function.
     */
    public function indexAction()
    {

    }
}