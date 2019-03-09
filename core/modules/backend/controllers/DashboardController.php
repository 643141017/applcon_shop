<?php

namespace Applcon\Backend\Controllers;

use Applcon\Models\Dashboard;
use Applcon\Backend\Forms\DashboardForm;

/**
 * \Applcon\Backend\Controllers\DashboardController
 *
 * @package Applcon\Dashboard\Controllers
 */
class DashboardController extends ControllerBase
{

    /**
     * @var \Applcon\Models\Dashboard
     */
    private $model;

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Dashboard index.
     */
    public function indexAction()
    {

    }
}
