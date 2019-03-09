<?php

namespace Applcon\Common\Library\Annotations\Adapter;

use Phalcon\Annotations\Adapter\Memory as PhMemory;
use Applcon\Common\Library\Annotations\AdapterTrait;

/**
 * \Applcon\Common\Library\Annotations\Adapter\Memory
 *
 * @package Applcon\Common\Library\Annotations\Adapter
 */
class Memory extends PhMemory
{
    use AdapterTrait;
}
