<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Domain\Entity\Operation;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\AbstractHydrator;

class OperationGateway extends AbstractGateway
{
    /**
     * @var Operation
     */
    protected $prototype;

    /**
     * OperationGateway constructor.
     * @param AdapterInterface $adapter
     * @param AbstractHydrator $hydrator
     * @param Operation $prototype
     */
    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator, Operation $prototype)
    {
        $this->prototype = $prototype;
        parent::__construct($adapter, $hydrator);
    }


    /**
     * @return Operation
     */
    protected function getPrototype() : Operation
    {
        return $this->prototype;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'operation';
    }
}