<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Model\Exception;


class CredentialsRequiredException extends AbstractModelException
{
    public function __construct()
    {
        parent::__construct("Credentials required", CredentialsRequiredException::CODE_CREDENTIALS_REQUIRED);
    }

}