<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\DTO;


class Credentials
{
    protected $credentials;
    protected $currencyCode;
    protected $paymentSystem;

    /**
     * @return mixed
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param mixed $credentials
     */
    public function setCredentials($credentials): void
    {
        $this->credentials = $credentials;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param mixed $currencyCode
     */
    public function setCurrencyCode($currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return mixed
     */
    public function getPaymentSystem()
    {
        return $this->paymentSystem;
    }

    /**
     * @param mixed $paymentSystem
     */
    public function setPaymentSystem($paymentSystem): void
    {
        $this->paymentSystem = $paymentSystem;
    }

}