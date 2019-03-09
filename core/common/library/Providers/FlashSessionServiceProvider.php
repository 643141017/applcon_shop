<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Flash\Session;

/**
 * \Applcon\Common\Library\Providers\FlashSessionServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class FlashSessionServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'flashSession';

    protected $bannerStyle = [
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ];

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $bannerStyle = $this->bannerStyle;

        $this->di->setShared(
            $this->serviceName,
            function () use ($bannerStyle) {
                $flash = new Session();

                $flash->setAutoescape(true);
                $flash->setDI($this);
                $flash->setCssClasses($bannerStyle);

                return $flash;
            }
        );
    }
}
