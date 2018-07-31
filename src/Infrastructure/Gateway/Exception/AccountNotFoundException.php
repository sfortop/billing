<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


class AccountNotFoundException extends AbstractNotFoundException
{
    public function __construct($credential)
    {
        parent::__construct(
            sprintf("Account for [%s] not found", $credential),
            AccountNotFoundException::CODE_ACCOUNT_NOT_FOUND);
    }
}