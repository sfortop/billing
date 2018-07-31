<?php

/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Entity;


use Infrastructure\Entity\EntityInterface;

class Account implements EntityInterface
{
    /**
     * @var string
     */
    protected $uuid;
    /**
     * @var string
     */
    protected $credential;
    /**
     * @var string
     */
    protected $amount = '0';
    /**
     * @var string
     */
    protected $currencyCode;
    /**
     * @var string
     */
    protected $dateCreate;
    /**
     * @var string
     */
    protected $customer;
    /**
     * @var string
     */
    protected $paymentSystem;
    /**
     * @var bool
     */
    protected $isDebtAllowed = false;

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
    public function getCredential(): ?string
    {
        return $this->credential;
    }

    /**
     * @param string $credential
     */
    public function setCredential(string $credential): void
    {
        $this->credential = $credential;
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
    public function getPaymentSystem(): string
    {
        return $this->paymentSystem;
    }

    /**
     * @param string $paymentSystem
     */
    public function setPaymentSystem(string $paymentSystem): void
    {
        $this->paymentSystem = $paymentSystem;
    }

    /**
     * @return bool
     */
    public function isDebtAllowed(): bool
    {
        return $this->isDebtAllowed;
    }

    /**
     * @param bool $isDebtAllowed
     */
    public function setIsDebtAllowed(bool $isDebtAllowed): void
    {
        $this->isDebtAllowed = $isDebtAllowed;
    }

}