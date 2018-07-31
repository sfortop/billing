<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Domain\Entity\Account;
use Infrastructure\Gateway\Exception\AccountNotFoundException;
use Infrastructure\Gateway\Exception\AccountNotFoundWithCurrencyException;
use Infrastructure\Gateway\Exception\AccountNotSavedException;
use Ramsey\Uuid\Uuid;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Where;
use Zend\Hydrator\AbstractHydrator;

class AccountGateway extends AbstractGateway
{
    /**
     * @var Account
     */
    protected $prototype;

    /**
     * AccountGateway constructor.
     * @param AdapterInterface $adapter
     * @param AbstractHydrator $hydrator
     * @param Account $prototype
     */
    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator, Account $prototype)
    {
        $this->prototype = $prototype;
        parent::__construct($adapter, $hydrator);
    }

    public function updateBalances($debitAccount, $creditAccount, $amount)
    {
        $update = new Update($this->getTable());

        $expression = new Expression("CASE WHEN uuid = :debit THEN amount - :debitAmount WHEN uuid = :credit THEN amount + :creditAmount END");
        $update->set(['amount' => $expression]);

        $where = new Where();
        $where->expression('uuid IN (?, ?)',[$debitAccount, $creditAccount]);
        $update->where($where);


        $stmt = $update->prepareStatement($this->getTableGateway()->getAdapter(), $this->getTableGateway()->getAdapter()->getDriver()->createStatement());

        $result = $stmt->execute([
            'debit' => $debitAccount,
            'debitAmount' => $amount,
            'credit' => $creditAccount,
            'creditAmount' => $amount,
        ]);
        return $result;
    }


    /**
     * @return Account
     */
    protected function getPrototype() : Account
    {
        return $this->prototype;
    }

    /**
     * @return Account
     */
    public function create() : Account
    {
        /** @var Account $account */
        $account = parent::create();
        $account->setUuid(Uuid::uuid4());
        $account->setDateCreate(date('Y-m-d H:i:s'));
        return $account;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'account';
    }

    /**
     * @param Account $account
     * @return Account Account
     * @throws AccountNotSavedException
     */
    public function save(Account $account)
    {
        $data = $this->getHydrator()->extract($account);
        try {
            $this->find($account->getCredential());
            $affectedRows = $this->tableGateway->update($data, ['uuid' => $account->getUuid()]);
        } catch (AccountNotFoundException $e) {
            $affectedRows = $this->getTableGateway()->insert($data);
        }

        if (!$affectedRows) {
            $errorInfo = $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->errorInfo();
            $errorCode = $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->errorCode();
            throw new AccountNotSavedException($account, $errorInfo, $errorCode);
        }
        return $account;
    }

    /**
     * @param $credential
     * @return \Zend\Db\ResultSet\ResultSet of Accounts
     * @throws AccountNotFoundException
     */
    public function find($credential)
    {
        $result = $this->getTableGateway()->select(['credential = ?' => $credential]);
        if (!$result->count()) {
            throw new AccountNotFoundException($credential);
        }
        return $result;
    }

    /**
     * @param $credential
     * @param $currencyCode
     * @return Account
     * @throws AccountNotFoundWithCurrencyException
     */
    public function findWithCurrency($credential, $currencyCode) : Account
    {
        $result = $this->getTableGateway()->select(['credential = ?' => $credential, 'currency_code = ? ' => $currencyCode]);

        if (!$result->count()) {
            throw new AccountNotFoundWithCurrencyException($credential, $currencyCode);
        } else {
            return $result->current();
        }
    }
}