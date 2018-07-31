<?php

namespace Domain\Entity;

use Infrastructure\Entity\EntityInterface;


/**
 * Customer
 */
class Customer implements EntityInterface
{
    /**
     * @var string
     */
    protected $uuid;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $pubkey;
    /**
     * @var string
     */
    protected $seckey;
    /**
     * @var string
     */
    protected $customerPubKey;
    /**
     * Client's signature used to sign any sensitive data
     * @var string
     */
    protected $signature;
    /**
     * @var string
     */
    protected $encoder;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPubkey(): ?string
    {
        return $this->pubkey;
    }

    /**
     * @param string $pubkey
     */
    public function setPubkey(string $pubkey): void
    {
        $this->pubkey = $pubkey;
    }

    /**
     * @return string
     */
    public function getSeckey(): ?string
    {
        return $this->seckey;
    }

    /**
     * @param string $seckey
     */
    public function setSeckey(string $seckey): void
    {
        $this->seckey = $seckey;
    }

    /**
     * @return string
     */
    public function getCustomerPubKey(): ?string
    {
        return $this->customerPubKey;
    }

    /**
     * @param string $customerPubKey
     */
    public function setCustomerPubKey(string $customerPubKey): void
    {
        $this->customerPubKey = $customerPubKey;
    }

    /**
     * @return string
     */
    public function getSignature(): ?string 
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getEncoder(): ?string
    {
        return $this->encoder;
    }

    /**
     * @param string $encoder
     */
    public function setEncoder(string $encoder): void
    {
        $this->encoder = $encoder;
    }

}