<?php

namespace Applcon\Frontend\Controllers;

/**
 * Class CategoryController
 * This class to index page
 *
 * @package Applcon\Frontend\Controllers
 */
class CategoryController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->view->pick('category');
    }

    /**
     * indexAction function.
     */
    public function indexAction()
    {

    }
}