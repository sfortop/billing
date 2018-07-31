<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


abstract class AbstractException extends \Exception
{
    const CODE_ACCOUNT_NOT_SAVED  = 1001;
    const CODE_ACCOUNT_NOT_FOUND  = 1002;
    const CODE_ACCOUNT_NOT_FOUND_WITH_CURRENCY = 1003;
    const CODE_CURRENCY_NOT_FOUND = 1004;
    const CODE_CURRENCY_NOT_SAVED = 1005;
    const CODE_TRANSACTION_NOT_SAVED = 1006;
    const CODE_TRANSACTION_NOT_FOUND = 1007;
    const CODE_TRANSACTION_ALREADY_EXISTS = 1008;
    const CODE_TRANSACTION_STATUS_NOT_SET = 1009;
    const CODE_DUPLICATE_KEY = 1010;
}