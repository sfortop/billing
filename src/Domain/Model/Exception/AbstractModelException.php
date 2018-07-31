<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Model\Exception;


abstract class AbstractModelException extends \Exception
{
    const CODE_CREDENTIALS_REQUIRED = 2001;
}