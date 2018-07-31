<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\DTO;


class Identity
{
    /**
     * @var string
     */
    protected $uuid;

    /**
     * @return string
     */
    public function getUuid() : string
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    public function __toString()
    {
        return $this->getUuid();
    }

}