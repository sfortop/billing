<?php

/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Entity;


use Infrastructure\Entity\EntityInterface;

class Transaction implements EntityInterface
{
    /**
     * @var string
     */
    protected $uuid;
    /**
     * @var string
     */
    protected $debitAccount;
    /**
     * @var string
     */
    protected $creditAccount;
    /**
     * @var string
     */
    protected $amount;
    /**
     * @var string
     */
    protected $currencyCode;
    /**
     * @var string
     */
    protected $comment;
    /**
     * @var string
     */
    protected $dateCreate;
    /**
     * @var string
     */
    protected $customerTransaction;
    /**
     * @var string
     */
    protected $customer;
    /**
     * @var string
     */
    protected $statusCode;

    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
    /**
     * @return string
     */
    public function getDebitAccount(): ?string
    {
        return $this->debitAccount;
    }

    /**
     * @param string $debitAccount
     */
    public function setDebitAccount(string $debitAccount): void
    {
        $this->debitAccount = $debitAccount;
    }

    /**
     * @return string
     */
    public function getCreditAccount(): ?string
    {
        return $this->creditAccount;
    }

    /**
     * @param string $creditAccount
     */
    public function setCreditAccount(string $creditAccount): void
    {
        $this->creditAccount = $creditAccount;
    }

    /**
     * @return string
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     */
    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getDateCreate(): ?string
    {
        return $this->dateCreate;
    }

    /**
     * @param string $dateCreate
     */
    public function setDateCreate(string $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return string
     */
    public function getCustomerTransaction(): ?string
    {
        return $this->customerTransaction;
    }

    /**
     * @param string $customerTransaction
     */
    public function setCustomerTransaction(string $customerTransaction): void
    {
        $this->customerTransaction = $customerTransaction;
    }

    /**
     * @return string
     */
    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     */
    public function setCustomer(string $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     */
    public function setStatusCode(string $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

}