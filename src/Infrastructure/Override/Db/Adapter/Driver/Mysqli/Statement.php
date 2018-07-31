<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Override\Db\Adapter\Driver\Mysqli;


use Zend\Db\Adapter\Exception\RuntimeException;

class Statement extends \Zend\Db\Adapter\Driver\Mysqli\Statement
{
    public function execute($parameters = null)
    {
        try {
            return parent::execute($parameters);
        } catch (RuntimeException $runtimeException) {
            throw new \RuntimeException($this->resource->error, $this->resource->sqlstate);
        }
    }

}