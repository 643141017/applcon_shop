<?php

namespace Applcon\Common\Library\Providers;

use Applcon\Common\Library\Annotations\Adapter\Memory;

/**
 * \Applcon\Common\Library\Providers\AnnotationsServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class AnnotationsServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'annotations';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, Memory::class);
    }
}
