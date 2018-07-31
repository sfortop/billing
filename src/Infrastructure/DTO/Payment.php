<?php
/**
 * billing
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\DTO;

class Payment
{
    /**
     * @var string
     */
    private $amount;

    /**
     * Currency code
     * 
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $credentials;

    /**
     * @var string
     */
    private $fromCredentials;

    /**
     * @var string
     */
    private $paymentSystem;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $customerTransaction;

    /**
     * @var string
     */
    private $customer;

    /**
     * Payment constructor.
     * @param string $amount
     */
    public function __construct($amount = null)
    {
        if ($amount) {
            $this->amount = $amount;
        }
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
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getCredentials(): ?string
    {
        return $this->credentials;
    }

    /**
     * @param string $credentials
     */
    public function setCredentials(string $credentials): void
    {
        $this->credentials = $credentials;
    }

    /**
     * @return string
     */
    public function getFromCredentials(): ?string
    {
        return $this->fromCredentials;
    }

    /**
     * @param string $fromCredentials
     */
    public function setFromCredentials(string $fromCredentials): void
    {
        $this->fromCredentials = $fromCredentials;
    }

    /**
     * @return string
     */
    public function getPaymentSystem(): ?string
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
    public function getOperation(): ?string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
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

}
