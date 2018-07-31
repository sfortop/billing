<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


use Domain\Entity\Account;

class AccountNotSavedException extends AbstractNotSavedException
{
    public function __construct(Account $account, $errorInfo, $errorCode)
    {
        parent::__construct(
            sprintf("Account [%s] couldn't saved. Response [%s] %s",
                $account->getUuid(),
                $errorInfo,
                $errorCode
            ),
            AccountNotSavedException::CODE_ACCOUNT_NOT_SAVED);
    }

}