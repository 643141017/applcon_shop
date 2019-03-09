<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Crypt;

/**
 * \Applcon\Common\Library\Providers\CryptServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class CryptServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'crypt';

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

                $crypt = new Crypt();
                $crypt->setKey($config->application->cryptSalt);

                return $crypt;
            }
        );
    }
}
