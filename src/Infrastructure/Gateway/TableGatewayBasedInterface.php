<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway;


interface TableGatewayBasedInterface
{
    /**
     * @return string
     */
    public function getTable() : string;

}