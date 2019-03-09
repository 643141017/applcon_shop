<?php

namespace Applcon\Common\Library\Events;

use Phalcon\Events\Event;
use Phalcon\Db\Adapter\Pdo;

/**
 * \Applcon\Common\Library\Events\DbListener
 *
 * @package Applcon\Common\Library\Events
 */
class DbListener extends AbstractEvent
{
    /**
     * Database queries listener.
     *
     * You can disable queries logging by changing log level.
     *
     * @param  Event $event
     * @param  Pdo   $connection
     * @return bool
     */
    public function beforeQuery(Event $event, Pdo $connection)
    {
        $string    = $connection->getSQLStatement();
        $variables = $connection->getSqlVariables();
        $context   = $variables ?: [];

        $logger = $this->getDI()->getLogger(date('Y-m-d') . '-' . 'db');

        if (!empty($context)) {
            $context = ' [' . implode(', ', $context) . ']';
        } else {
            $context = '';
        }

        $logger->debug($string . $context);

        return true;
    }
}
