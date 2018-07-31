<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


use Domain\Entity\Transaction;

class TransactionAlreadyExistsException extends AbstractException
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct(
            sprintf('Transaction [%s] for [%s] as [%s] already exists',
                $transaction->getUuid(),
                $transaction->getCustomer(),
                $transaction->getCustomerTransaction()
            ),
            TransactionAlreadyExistsException::CODE_TRANSACTION_ALREADY_EXISTS);
    }
}