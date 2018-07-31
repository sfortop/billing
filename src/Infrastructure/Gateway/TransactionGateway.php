<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


use Domain\Entity\Transaction;
use Infrastructure\DTO\Credentials;
use Infrastructure\Gateway\Exception\DuplicateKeyException;
use Infrastructure\Gateway\Exception\TransactionAlreadyExistsException;
use Infrastructure\Gateway\Exception\TransactionNotFoundException;
use Infrastructure\Gateway\Exception\TransactionNotSavedException;
use Infrastructure\Gateway\Exception\TransactionStatusNotSetException;
use Ramsey\Uuid\Uuid;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Hydrator\AbstractHydrator;

class TransactionGateway extends AbstractGateway
{
    /**
     * array of SQLSTATE = > [error code => Exception class]
     *
     * @var array
     */
    protected $exceptionMapping = [
        23000 => [
            1062 => DuplicateKeyException::class
        ],
    ];

    /**
     * @var Transaction
     */
    protected $prototype;

    /**
     * TransactionGateway constructor.
     * @param AdapterInterface $adapter
     * @param AbstractHydrator $hydrator
     * @param Transaction $prototype
     */
    public function __construct(AdapterInterface $adapter, AbstractHydrator $hydrator, Transaction $prototype)
    {
        $this->prototype = $prototype;
        parent::__construct($adapter, $hydrator);
    }

    public function create()
    {
        /** @var Transaction $transaction */
        $transaction = parent::create();
        $transaction->setDateCreate(date('Y-m-d H:i:s'));
        $transaction->setUuid(Uuid::uuid4());
        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     * @throws TransactionAlreadyExistsException
     * @throws TransactionNotSavedException
     * @throws DuplicateKeyException
     */
    public function insert(Transaction $transaction)
    {
        $data = $this->getHydrator()->extract($transaction);
        try {
            $this->find($transaction->getUuid());
            throw new TransactionAlreadyExistsException($transaction);
        } catch (TransactionNotFoundException $e) {
        }
        try {
            $affectedRows = $this->getTableGateway()->insert($data);
        } catch (InvalidQueryException $e) {
            $previous = $e->getPrevious();
            if ($previous instanceof \PDOException) {
                $errorInfo = $previous->errorInfo;
                if (
                    // SQLSTATE CODE
                    isset($this->exceptionMapping[$errorInfo[0]]) &&
                    // ERROR CODE
                    isset($this->exceptionMapping[$errorInfo[0]][$errorInfo[1]])
                ) {
                    $exceptionClass = $this->exceptionMapping[$errorInfo[0]][$errorInfo[1]];

                    throw new $exceptionClass($errorInfo[2], $errorInfo[1]);
                }
            }
        }
        if (!$affectedRows) {

            /** @var \PDO $connection */
            $connection = $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->getResource();
            $errorInfo = $connection->errorInfo();
            $errorCode = $connection->errorCode();

            throw new TransactionNotSavedException($transaction, $errorInfo, $errorCode);
        }
        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     * @throws TransactionNotSavedException
     * @deprecated use insert and setStatus methods
     */
    protected function save(Transaction $transaction)
    {
        $data = $this->getHydrator()->extract($transaction);
        try {
            $this->find($transaction->getUuid());
            $affectedRows = $this->tableGateway->update($data, ['uuid' => $transaction->getUuid()]);
        } catch (TransactionNotFoundException $e) {
            $affectedRows = $this->getTableGateway()->insert($data);
        }
        if (!$affectedRows) {
            /** @var \PDO $connection */
            $connection = $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->getResource();
            $errorInfo = $connection->errorInfo();
            $errorCode = $connection->errorCode();
            throw new TransactionNotSavedException($transaction, $errorInfo, $errorCode);
        }
        return $transaction;
    }

    /**
     * @param Transaction $transaction
     * @param $statusCode
     * @return Transaction
     * @throws TransactionNotFoundException
     * @throws TransactionStatusNotSetException
     */
    public function setStatus(Transaction $transaction, $statusCode)
    {
        $this->find($transaction->getUuid());

        $transaction->setStatusCode($statusCode);

        $data = $this->getHydrator()->extract($transaction);

        $affectedRows = $this->tableGateway->update($data, ['uuid' => $transaction->getUuid()]);
        if (!$affectedRows) {
            /** @var \PDO $connection */
            $connection = $this->getTableGateway()->getAdapter()->getDriver()->getConnection()->getResource();
            $errorInfo = $connection->errorInfo();
            $errorCode = $connection->errorCode();
            throw new TransactionStatusNotSetException($transaction, $errorInfo, $errorCode);
        }
        return $transaction;
    }

    /**
     * @return Transaction
     */
    protected function getPrototype() : Transaction
    {
        return $this->prototype;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'transaction';
    }

    /**
     * @param $uuid
     * @return Transaction
     * @throws TransactionNotFoundException
     */
    public function find($uuid)
    {
        $result = $this->tableGateway->select(['uuid = ?' => $uuid]);
        if (!$result->count()) {
            throw new TransactionNotFoundException($uuid);
        }
        /** @var Transaction $transaction */
        $transaction = $result->current();
        return $transaction;
    }

    /**
     * @param Credentials $credential
     * @return Transaction[]
     */
    public function findAll(Credentials $credential)
    {
        $select = new Select($this->getTable());
        $select->join(['debit' => 'account'],
            new Expression('debit_account = debit.uuid AND debit.credential = ?', [$credential->getCredentials()]),
            ['cr' => 'uuid'],
            Join::JOIN_LEFT);
        $select->join(['credit' => 'account'],
            new Expression('credit_account = credit.uuid AND credit.credential = ?', [$credential->getCredentials()]),
            ['dt' => 'uuid'],
            Join::JOIN_LEFT);
        $select->where(
            new Expression('? IN (debit.credential, credit.credential)', $credential->getCredentials())
        );

        $resultSet = $this->getTableGateway()->selectWith($select);
        $result = [];
        foreach ($resultSet as $transaction) {
            $result[] = $transaction;
        }
        return $result;
    }
}