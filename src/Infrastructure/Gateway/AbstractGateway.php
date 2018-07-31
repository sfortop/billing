<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Infrastructure\Entity\EntityInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\AbstractHydrator;

abstract class AbstractGateway implements TableGatewayBasedInterface
{
    protected $tableGateway;
    /**
     * @var AbstractHydrator
     */
    protected $hydrator;

    /**
     * @return EntityInterface
     */
    abstract protected function getPrototype();

    /**
     * AccountGateway constructor.
     * @param AdapterInterface $adapter
     * @param AbstractHydrator $hydrator
     */
    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator)
    {
        $this->tableGateway = new TableGateway($this->getTable(), $adapter,null,
            new HydratingResultSet($hydrator, $this->getPrototype())
        );
        $this->hydrator = $hydrator;
    }

    /**
     * @return EntityInterface
     */
    public function create()
    {
        return clone $this->getPrototype();
    }

    /**
     * @param $data
     * @return object
     */
    public function createFromArray($data)
    {
        /** @var HydratingResultSet $resultSet */
        $resultSet = $this->getTableGateway()->getResultSetPrototype();
        return $resultSet->getHydrator()->hydrate($data, $resultSet->getObjectPrototype());
    }

    /**
     * @return TableGateway
     */
    protected function getTableGateway() : TableGateway
    {
        return $this->tableGateway;
    }

    protected function getHydrator(): AbstractHydrator
    {
        return $this->hydrator;
    }
}