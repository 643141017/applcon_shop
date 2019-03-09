<?php

namespace Applcon\Oauth\Controllers;

/**
 * \Applcon\Oauth\Controllers\LogoutController
 *
 * @package Applcon\Oauth\Controllers
 */
class LogoutController extends ControllerBase
{
    /**
     * Log Out Action
     */
    public function indexAction()
    {
        // Destroy the whole session
        $this->auth->remove();
        $this->response->redirect('/backend');
    }
}
