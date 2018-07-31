<?php

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Encryption\Encoder\Exception;

use Throwable;

/**
 * Class PrivateKeyNotLoadedException
 * @package Encryption\Encoder\Exception
 * @author <clarifying@gmail.com>
 */
class PrivateKeyNotLoadedException extends KeyNotLoadedException
{
    public function __construct(string $message = "", int $code = EncoderException::CODE_CANT_LOAD_PRIVATE_KEY, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}