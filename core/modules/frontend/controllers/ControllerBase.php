<?php

namespace Applcon\Frontend\Controllers;

use Applcon\Controllers\Controller;
use Phalcon\Mvc\DispatcherInterface;
use Applcon\Models\Services\Service;
use Applcon\Frontend\Forms\CommentForm;
use Applcon\Models\ActivityNotifications;

/**
 * \Applcon\Frontend\Controllers\ControllerBase
 *
 * @property \Applcon\Auth\Auth $auth
 * @property \Phalcon\Config $config
 * @property \Applcon\Utils\Applcon $Applcon
 *
 * @package Applcon\Controllers
 */
class ControllerBase extends Controller
{
    /**
     * @var int
     */
    public $perPage = 30;

    /**
     * 在执行控制器/操作方法之前触发
     *
     * @param  DispatcherInterface $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(DispatcherInterface $dispatcher)
    {
        if ($this->auth->hasRememberMe() && !$this->request->isPost()) {
            $this->auth->loginWithRememberMe();
        }

        return true;
    }

    /**
     * 初始化
     *
     */
    public function initialize()
    {
        if (isset($this->config->perPage)) {
            $this->perPage = $this->config->perPage;
        }
    }

    /**
     * 注入服务
     *
     */
    public function inject()
    {
        
    }

    /**
     * 将值从控制器传输到视图
     *
     * @param array $params
     */
    public function setViewVariable($params)
    {
        foreach ($params as $key => $value) {
            $this->view->setVar($key, $value);
        }
    }
}
