<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Security;

/**
 * \Applcon\Common\Library\Providers\SecurityServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class SecurityServiceProvider extends AbstractServiceProvider
{
    const DEFAULT_WORK_FACTOR = 12;

    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'security';

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

                $security = new Security();

                $workFactor = SecurityServiceProvider::DEFAULT_WORK_FACTOR;
                if (isset($config->application->hashingFactor)) {
                    $workFactor = (int) $config->application->hashingFactor;
                }

                $security->setWorkFactor($workFactor);

                return $security;
            }
        );
    }
}
