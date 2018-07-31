<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Encryption\Encoder\Exception;


use Throwable;

class PublicKeyNotLoadedException extends KeyNotLoadedException
{
    public function __construct(string $message = "", int $code = EncoderException::CODE_CANT_LOAD_PUBLIC_KEY, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}