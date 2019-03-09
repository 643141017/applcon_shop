<?php

namespace Applcon\Models;

use Phalcon\Mvc\Model;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Applcon\Models\Behavior\Blameable as ModelBlameable;

/**
 * \Applcon\Models\ModelBase
 *
 * It is common model basics for Mysql
 *
 * @package Applcon\Models
 */
class ModelBase extends Model
{

    public static function getConnection()
    {
        $di = FactoryDefault::getDefault();

        return $di->get('db');
    }


    /**
     * The function sending log for nginx or apache, it will to analytic later
     *
     * @param $e
     */
    public function saveLogger($e)
    {
        $logger = $this->getDI()->getLogger();
        if (is_object($e)) {
            $logger->error($e[0]->getMessage());
        }
        if (is_array($e)) {
            foreach ($e as $message) {
                $logger->error($message->getMessage());
            }
        }
        if (is_string($e)) {
            $logger->error($e);
        }
    }

    /**
     * Hook Phalcon PHP
     */
    public function initialize()
    {
        $this->addBehavior(new ModelBlameable());
        $this->keepSnapshots(true);
    }

    /**
     * Map data table (complement table prefix)
     * @param string $tableName
     * @param null $prefix
     */
    protected function setTableSource($tableName, $prefix = null){
        empty($prefix) && $prefix = $this->getDI()->get('config')->database->prefix;
        $this->setSource($prefix . $tableName);
    }
}
