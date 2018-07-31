<?php

namespace Domain\Entity;

use Infrastructure\Entity\EntityInterface;

/**
 * Class TransactionStatus
 *
 * @package Domain\Entity
 */
class TransactionStatus implements EntityInterface
{
    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_APPROVAL_REQUIRED,
        self::STATUS_APPROVED,
        self::STATUS_COMPLETED,
        self::STATUS_NOT_APPROVED,
        self::STATUS_PROCESSING,
        self::STATUS_ERROR,
        self::STATUS_CANCELLED,
        self::STATUS_FRAUDULENT,
        self::STATUS_AWAITING_CONFIRMATION,
        self::STATUS_READY_FOR_BALANCE_UPDATE,
        self::STATUS_REFUNDED,
        self::STATUS_UNPROCESSED,
    ];

    const STATUS_NEW = "PGTW_100";
    const STATUS_APPROVAL_REQUIRED = "PGTW_101";
    const STATUS_APPROVED = "PGTW_102";
    const STATUS_READY_FOR_BALANCE_UPDATE = "PGTW_190";
    const STATUS_COMPLETED = "PGTW_200";
    const STATUS_REFUNDED = 'PGTW_204';
    const STATUS_PROCESSING = "PGTW_300";
    const STATUS_AWAITING_CONFIRMATION = "PGTW_301";
    const STATUS_ERROR = "PGTW_400";
    const STATUS_CANCELLED = "PGTW_401";
    const STATUS_FRAUDULENT = "PGTW_402";
    const STATUS_NOT_APPROVED = "PGTW_403";
    const STATUS_UNPROCESSED = 'PGTW_410';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $code;

    public function __construct($code = null, $name = null)
    {
        if ($code) $this->setCode($code);
        if ($name) $this->setName($name);
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

}