<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


class TransactionNotFoundException extends AbstractNotFoundException
{
    public function __construct($transaction)
    {
        parent::__construct(
            sprintf('Transaction [%s] not found', $transaction),
            TransactionNotFoundException::CODE_TRANSACTION_NOT_FOUND);
    }

}