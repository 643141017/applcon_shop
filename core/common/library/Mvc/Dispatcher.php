<?php

namespace Applcon\Common\Library\Mvc;

use Phalcon\Mvc\Dispatcher as PhDispatcher;

/**
 * \Applcon\Common\Library\Mvc\Dispatcher
 *
 * @package Applcon\Common\Library\Mvc
 */
class Dispatcher extends PhDispatcher
{
    /**
     * {@inheritdoc}
     *
     * @param array $forward
     */
    public function forward($forward)
    {
        $this->getEventsManager()->fire('dispatch:beforeForward', $this, $forward);

        parent::forward($forward);
    }
}
