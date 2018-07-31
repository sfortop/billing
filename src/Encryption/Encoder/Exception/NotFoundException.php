<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Encryption\Encoder\Exception;


use Throwable;

class NotFoundException extends EncoderException
{
    public function __construct(string $message = "", int $code = EncoderException::CODE_NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}