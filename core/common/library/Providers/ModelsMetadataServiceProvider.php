<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Mvc\Model\Metadata\Memory;

/**
 * \Applcon\Common\Library\Providers\ModelsMetadataServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class ModelsMetadataServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'modelsMetadata';

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
                $metadata = new Memory();

                return $metadata;
            }
        );
    }
}
