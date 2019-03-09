<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Escaper;

/**
 * \Applcon\Common\Library\Providers\EscaperServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class EscaperServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'escaper';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, Escaper::class);
    }
}
