<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Entity;


use Infrastructure\Entity\EntityInterface;

class Operation implements EntityInterface
{

    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $code;

    /**
     * Operation constructor.
     * @param null|string $code
     * @param null|string $name
     */
    public function __construct($code = null, $name = null)
    {
        if ($code) $this->setCode($code);
        if ($name) $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName(): string
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
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

}