<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


use Domain\Entity\Transaction;

class TransactionStatusNotSetException extends AbstractException
{
    public function __construct(Transaction $transaction, $errorInfo, $errorCode)
    {
        parent::__construct(
            sprintf('Transaction [%s] status to [%s] not set',
                $transaction->getUuid(),
                $transaction->getStatusCode(),
                $errorInfo,
                $errorCode),
            TransactionStatusNotSetException::CODE_TRANSACTION_STATUS_NOT_SET);
    }
}