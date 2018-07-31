<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Domain\Entity\Currency;
use Infrastructure\Gateway\Exception\CurrencyNotFoundException;
use Infrastructure\Gateway\Exception\CurrencyNotSavedException;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\AbstractHydrator;

class CurrencyGateway extends AbstractGateway
{
    /**
     * @var Currency
     */
    protected $prototype;

    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator, Currency $prototype)
    {
        $this->prototype = $prototype;
        parent::__construct($adapter, $hydrator);
    }

    /**
     * @param Currency $currency
     * @return Currency
     * @throws CurrencyNotSavedException
     */
    public function save(Currency $currency) : Currency
    {
        $data = $this->getHydrator()->extract($currency);

        $affectedRows = $this->getTableGateway()->insert($data);
        if (!$affectedRows) {
            throw new CurrencyNotSavedException($currency);
        }
        return $currency;
    }

    /**
     * @return Currency
     * @todo make convienent way to create
     */
    public function create() : Currency
    {

        /** @var Currency $currency */
        $currency = parent::create();
        return $currency;
    }


    /**
     * @param $code
     * @return Currency
     * @throws CurrencyNotFoundException
     */
    public function find($code) : Currency
    {
        $result = $this->getTableGateway()->select(['code = ?' => $code ]);
        if (!$result->count()) {
            throw new CurrencyNotFoundException($code);
        }
        return $result->current();
    }

    /**
     * @return Currency
     */
    protected function getPrototype(): Currency
    {
        return $this->prototype;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'currency';
    }
}