<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Cache\Frontend\Data;

/**
 * \Applcon\Common\Library\Providers\ModelsCacheServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class ModelsCacheServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modelsCache';

    protected $driverConfig = [];

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function configure()
    {
        /** @noinspection PhpIncludeInspection */
        $config = require config_path('cache.php');
        $driver = $config['default'];

        $this->driverConfig['config'] = $config['drivers'][$driver];
        $this->driverConfig['lifetime'] = $config['lifetime'];
        $this->driverConfig['prefix'] = $config['prefix'];
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $driverConfig = $this->driverConfig;

        $this->di->setShared(
            $this->serviceName,
            function () use ($driverConfig) {
                $adapter = '\Phalcon\Cache\Backend\\' . $driverConfig['config']['adapter'];

                unset($driverConfig['config']['adapter']);
                $driverConfig['config']['prefix'] = $driverConfig['prefix'];

                return new $adapter(
                    new Data(['lifetime' => $driverConfig['lifetime']]),
                    $driverConfig['config']
                );
            }
        );
    }
}
