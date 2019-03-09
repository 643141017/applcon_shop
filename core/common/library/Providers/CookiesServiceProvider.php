<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Http\Response\Cookies;

/**
 * \Applcon\Common\Library\Providers\CookiesServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class CookiesServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'cookies';

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
                $cookies = new Cookies();
                $cookies->useEncryption(true);

                return $cookies;
            }
        );
    }
}
