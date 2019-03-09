<?php

namespace Applcon\Common\Library\Providers;

use Applcon\Common\Library\Auth\Auth;

/**
 * \Applcon\Common\Library\Providers\AuthServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class AuthServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'auth';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                $auth = new Auth();
                $auth->setDI($this);
                $auth->setEventsManager($this->getShared('eventsManager'));

                return $auth;
            }
        );
    }
}
