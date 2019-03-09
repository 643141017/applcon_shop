<?php

namespace Applcon\Models\Services;

use Phalcon\Di;
use Phalcon\DiInterface;
use Phalcon\Di\Injectable;

/**
 * \Applcon\Models\Services\Service
 *
 * @property \Phalcon\Config $config
 * @property \Applcon\Auth\Auth $auth
 * @property \Phalcon\Security\Random $random
 * @property \Phalcon\Logger\AdapterInterface $logger
 *
 * @package Applcon\Models\Services
 */
abstract class Service extends Injectable
{
    /**
     * Service constructor.
     *
     * @param DiInterface|null $di
     */
    public function __construct(DiInterface $di = null)
    {
        $this->setDI($di ?: Di::getDefault());
    }

    protected function resolveClientAddress($ipAddress)
    {
        if (!$ipAddress && $this->getDI()->has('request')) {
            $ipAddress = $this->getDI()->getShared('request')->getClientAddress();
        }

        return $ipAddress;
    }

    protected function resolveVisitorId($visitorId)
    {
        if (!$visitorId && $this->getDI()->has('auth')) {
            $visitorId = $this->getDI()->getShared('auth')->getUserId();
        }

        return $visitorId;
    }
}
