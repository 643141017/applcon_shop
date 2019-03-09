<?php

namespace Applcon\Common\Library\Providers;

use Applcon\Common\Library\Utils\Applcon;

/**
 * \Applcon\Common\Library\Providers\ApplconServiceProvider
 *
 * @deprecated
 * @package Applcon\Common\Library\Providers
 */
class ApplconServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'applcon';

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

                $info = themes_path("{$config->theme}/info.php");

                if (!file_exists($info)) {
                    trigger_error('You need to created a file info theme', E_USER_ERROR);
                }

                /** @noinspection PhpIncludeInspection */
                return new Applcon(require $info);
            }
        );
    }
}
