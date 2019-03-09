<?php

namespace Applcon\Frontend\Controllers;

/**
 * Class ProductController
 * This class to index page
 *
 * @package Applcon\Frontend\Controllers
 */
class ProductController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->pick('product');
    }

    /**
     * indexAction function.
     */
    public function indexAction()
    {

    }
}
