<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Domain\Entity\Customer;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\AbstractHydrator;

class CustomerGateway extends AbstractGateway
{

    protected $prototype;

    /**
     * CustomerGateway constructor.
     * @param AdapterInterface $adapter
     * @param AbstractHydrator $hydrator
     * @param Customer $prototype
     */
    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator, Customer $prototype)
    {
        $this->prototype = $prototype;
        parent::__construct($adapter, $hydrator);
    }


    /**
     * @return Customer
     */
    protected function getPrototype() : Customer
    {
        return $this->prototype;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'customer';
    }
}