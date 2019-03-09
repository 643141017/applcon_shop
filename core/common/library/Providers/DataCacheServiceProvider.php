<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Cache\Backend\File as BackendFile;
use Phalcon\Cache\Frontend\None as FrontendNone;
use Phalcon\Cache\Backend\Memory as BackendMemory;

/**
 * \Applcon\Common\Library\Providers\DataCacheServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class DataCacheServiceProvider extends AbstractServiceProvider
{
    const DEFAULT_CACHE_TTL = 86400;

    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'dataCache';

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
                $config = $this->getShared('config')->application;

                if ($config->debug && (!isset($config->dataCache->force) || !$config->dataCache->force)) {
                    return new BackendMemory(new FrontendNone());
                }

                $frontendAdapter = FrontendNone::class;
                if (isset($config->frontend) && class_exists('\Phalcon\Cache\Frontend\\' . $config->frontend)) {
                    $frontendAdapter = '\Phalcon\Cache\Frontend\\' . $config->frontend;
                }

                $lifetime = DataCacheServiceProvider::DEFAULT_CACHE_TTL;
                if (isset($config->lifetime)) {
                    $lifetime = (int) $config->lifetime;
                }

                $backendAdapter = BackendFile::class;
                if (isset($config->backend) && class_exists('\Phalcon\Cache\Backend\\' . $config->backend)) {
                    $backendAdapter = '\Phalcon\Cache\Backend\\' . $config->backend;
                }

                /** @var \Phalcon\Config $config */
                $config = $config->toArray();

                unset($config['backend'], $config['lifetime'], $config['frontend']);

                return new $backendAdapter(
                    new $frontendAdapter(['lifetime' => $lifetime]),
                    $config
                );
            }
        );
    }
}
