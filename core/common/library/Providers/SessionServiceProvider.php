<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Session\Adapter\Files;

/**
 * \Applcon\Common\Library\Providers\SessionServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class SessionServiceProvider extends AbstractServiceProvider
{
    const UNIQUE_ID = 'applcon_';

    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'session';

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
                $config = $this->getShared('config')->application->session;

                if (isset($config->adapter)) {
                    $sessionAdapter = '\Phalcon\Session\Adapter\\'  . $config->adapter;
                    if (class_exists($sessionAdapter)) {
                        if (isset($config->domain)) {
                            ini_set('session.cookie_domain', $config->domain);
                        }
                        $options = $config->options->toArray();
                        /** @var \Phalcon\Session\AdapterInterface $session */
                        $session = new $sessionAdapter($options);
                        $session->start();

                        return $session;
                    }
                }

                $session = new Files(['uniqueId' => SessionServiceProvider::UNIQUE_ID]);
                $session->start();

                return $session;
            }
        );
    }
}
