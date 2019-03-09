<?php

namespace Applcon\Common\Library\Providers;

use PDO;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Applcon\Common\Library\Events\DbListener;

/**
 * \Applcon\Common\Library\Providers\DatabaseServiceProvider
 *
 * @package Applcon\Common\Library\Providers
 */
class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'db';

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

                $connection = new Mysql(
                    [
                        'host'     => $config->database->mysql->host,
                        'username' => $config->database->mysql->username,
                        'password' => $config->database->mysql->password,
                        'dbname'   => $config->database->mysql->dbname,
                        'options'  => [
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config->database->mysql->charset
                        ]
                    ]
                );

                $eventsManager = $this->getShared('eventsManager');
                $eventsManager->attach('db', new DbListener($this));

                $connection->setEventsManager($eventsManager);

                return $connection;
            }
        );
    }
}
