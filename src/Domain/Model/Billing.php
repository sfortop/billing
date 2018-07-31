<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Model;


use Domain\Entity\Account;
use Domain\Entity\Transaction;
use Domain\Entity\TransactionStatus;
use Domain\Model\Exception\BalanceTransferFailedException;
use Domain\Model\Exception\CredentialsRequiredException;
use Domain\Model\Exception\FromCredentialsRequiredException;
use Infrastructure\DTO\Payment;
use Infrastructure\Gateway\Exception\AccountNotFoundWithCurrencyException;
use Infrastructure\Gateway\Exception\AccountNotSavedException;
use Infrastructure\Gateway\Exception\DuplicateKeyException;
use Infrastructure\Gateway\Exception\TransactionAlreadyExistsException;
use Infrastructure\Gateway\Exception\TransactionNotFoundException;
use Infrastructure\Gateway\Exception\TransactionNotSavedException;
use Infrastructure\Gateway\Exception\TransactionStatusNotSetException;
use Infrastructure\Gateway\TransactionGateway;

class Billing
{
    /**
     * @var \Domain\Model\Account
     */
    private $account;
    /**
     * @var TransactionGateway
     */
    private $transactionGateway;

    /**
     * Billing constructor.
     * @param \Domain\Model\Account $account
     * @param TransactionGateway $transactionGateway
     */
    public function __construct(\Domain\Model\Account $account, TransactionGateway $transactionGateway)
    {
        $this->account = $account;
        $this->transactionGateway = $transactionGateway;
    }


    /**
     * Pay to billing account
     *
     * @param Payment $payment
     * @return Transaction
     * @throws AccountNotFoundWithCurrencyException
     * @throws AccountNotSavedException
     * @throws BalanceTransferFailedException
     * @throws CredentialsRequiredException
     * @throws TransactionAlreadyExistsException
     * @throws TransactionNotSavedException
     * @throws TransactionNotFoundException
     * @throws TransactionStatusNotSetException
     * @throws DuplicateKeyException
     */
    public function pay(Payment $payment)
    {
        if (!$payment->getCredentials()) {
            throw new CredentialsRequiredException();
        }

        $transaction = $this->createTransaction($payment);
        $transaction = $this->process($transaction);
        return $transaction;
    }

    /**
     * Withdraw from billing account
     *
     * @param Payment $payment
     * @return Transaction
     * @throws AccountNotFoundWithCurrencyException
     * @throws AccountNotSavedException
     * @throws BalanceTransferFailedException
     * @throws FromCredentialsRequiredException
     * @throws TransactionAlreadyExistsException
     * @throws TransactionNotSavedException
     * @throws TransactionNotFoundException
     * @throws TransactionStatusNotSetException
     * @throws DuplicateKeyException
     */
    public function withdraw(Payment $payment)
    {
        if (!$payment->getFromCredentials()) {
            throw new FromCredentialsRequiredException();
        }

        /** @var Transaction $transaction */
        $transaction =  $this->createTransaction($payment);
        $transaction = $this->process($transaction);

        return $transaction;
    }

    /**
     * Get transaction history
     *
     * @param $credential
     * @return Transaction[]
     */
    public function transactionHistory($credential)
    {
        /** @var Transaction[] $list */

        $list = $this->transactionGateway->findAll($credential);

        return $list;
    }

    /**
     * Get balances by currency list
     *
     * @param array $currencies
     * @return Account[]
     */
    public function balancesByCurrency(array $currencies)
    {

        $accounts = [];

        foreach ($currencies as $currency) {
            $account = new Account();
            $account->setCurrencyCode($currency);
            /** @var Account[] $accounts */
            $accounts[] = $account;
        }

        return $accounts;
    }

    /**
     * @param Payment $payment
     * @return Transaction
     * @throws AccountNotSavedException
     * @throws TransactionNotSavedException
     * @throws TransactionAlreadyExistsException
     * @throws DuplicateKeyException
     */
    public function createTransaction(Payment $payment): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionGateway->create();

        $transaction->setDebitAccount($this->account->getDebit($payment)->getUuid());
        $transaction->setCreditAccount($this->account->getCredit($payment)->getUuid());
        $transaction->setCurrencyCode($payment->getCurrency());
        $transaction->setCustomer($payment->getCustomer());
        $transaction->setAmount($payment->getAmount());
        $transaction->setComment($payment->getComment());
        $transaction->setCustomerTransaction($payment->getCustomerTransaction());
        $transaction->setStatusCode(TransactionStatus::STATUS_NEW);

        $this->transactionGateway->insert($transaction);
        return $transaction;
    }

    /**
     * @param $transaction
     * @return mixed
     * @throws BalanceTransferFailedException
     * @throws TransactionNotSavedException
     * @throws TransactionNotFoundException
     * @throws TransactionStatusNotSetException
     */
    public function process($transaction)
    {
        $result = $this->account->transferBalance($transaction->getDebitAccount(), $transaction->getCreditAccount(), $transaction->getAmount());
        if ($result->getAffectedRows() == 2) {
            $this->transactionGateway->setStatus($transaction, TransactionStatus::STATUS_COMPLETED);
        } else {
            throw new BalanceTransferFailedException($transaction);
        }
        return $transaction;
    }
}