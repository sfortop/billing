<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Domain\Entity\TransactionStatus;
use Infrastructure\Entity\EntityInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\AbstractHydrator;

class TransactionStatusGateway extends AbstractGateway
{
    /**
     * @var TransactionStatus
     */
    protected $prototype;

    /**
     * TransactionStatusGateway constructor.
     * @param AdapterInterface $adapter
     * @param AbstractHydrator $hydrator
     * @param TransactionStatus $prototype
     */
    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator, TransactionStatus $prototype)
    {
        $this->prototype = $prototype;
        parent::__construct($adapter, $hydrator);
    }

    /**
     * @return EntityInterface
     */
    protected function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'transaction_status';
    }
}