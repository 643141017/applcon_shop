<?php

namespace Applcon\Common\Library\Providers;

use Phalcon\Tag;

/**
 * \Applcon\Common\Library\Providers\TagServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class TagServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'tag';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, Tag::class);
    }
}
