<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Http\Request;

/**
 * \Applcon\Common\Library\Providers\RequestServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class RequestServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'request';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, Request::class);
    }
}
