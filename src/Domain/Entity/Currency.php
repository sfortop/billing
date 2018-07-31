<?php

namespace Domain\Entity;

use Infrastructure\Entity\EntityInterface;

class Currency implements EntityInterface
{

    /**
     * @var string
     */
    private $code='';

    /**
     * @var int
     */
    private $fraction = 2;

    public function __construct($code = null)
    {
        if ($code) $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
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

    /**
     * @return int
     */
    public function getFraction(): int
    {
        return $this->fraction;
    }

    /**
     * @param int $fraction
     */
    public function setFraction(int $fraction)
    {
        $this->fraction = $fraction;
    }
}

