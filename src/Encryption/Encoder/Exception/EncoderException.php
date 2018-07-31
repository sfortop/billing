<?php
/**
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Encryption\Encoder\Exception;


class EncoderException extends \Exception
{
    const TAG_CANT_LOAD_PRIVATE_KEY = "auth.cant_load_private_key";
    const TAG_CANT_LOAD_PUBLIC_KEY = "auth.cant_load_public_key";
    const TAG_NOT_FOUND = "auth.encoder_not_found";

    const CODE_CANT_LOAD_PRIVATE_KEY = 9002;
    const CODE_CANT_LOAD_PUBLIC_KEY = 9003;
    const CODE_NOT_FOUND = 9004;
}