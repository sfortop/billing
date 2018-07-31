<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


class AccountNotFoundWithCurrencyException extends AbstractNotFoundException
{
    public function __construct($credential, $currencyCode)
    {
        parent::__construct(
            sprintf("Account for [%s , %s] not found", $credential, $currencyCode),
            AccountNotFoundException::CODE_ACCOUNT_NOT_FOUND);
    }
}