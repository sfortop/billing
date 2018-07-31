<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Override\Db\Adapter;


use Infrastructure\Override\Db\Adapter\Driver\Mysqli\Statement;
use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Mysqli\Mysqli;

class MysqliAdapterServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $buffer = $config['db']['options']['buffer_results'] ? $config['db']['options']['buffer_results'] : true;

        $statement = new Statement($buffer);
        $adapter = new Adapter($config['db']);
        /** @var Mysqli $driver */
        $driver = $adapter->getDriver();
        $driver->registerStatementPrototype($statement);
        return $adapter;
    }


}