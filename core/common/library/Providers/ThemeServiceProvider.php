<?php

namespace Applcon\Common\Library\Providers;

use Applcon\Common\ThemeManager;

/**
 * \Applcon\Common\Library\Providers\ThemeServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class ThemeServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'theme';

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
                /** @var \Phalcon\DiInterface $this */
                $config = $this->getShared('config');

                $manager = new ThemeManager($config->theme);
                $manager->setDI($this);

                return $manager;
            }
        );

        $this->di->getShared($this->serviceName)->initializeAssets();
    }
}
