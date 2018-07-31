<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


use Domain\Entity\Transaction;

class TransactionNotSavedException extends AbstractNotSavedException
{
    public function __construct(Transaction $transaction, $errorInfo, $errorCode)
    {
        parent::__construct(
            sprintf("Transaction [%s] %s [%s] %s %s '%s' from %s to %s at %s couldn't saved. Response [%s] %s",
                $transaction->getUuid(),
                $transaction->getCustomer(),
                $transaction->getCustomerTransaction(),
                $transaction->getAmount(),
                $transaction->getCurrencyCode(),
                $transaction->getComment(),
                $transaction->getDebitAccount(),
                $transaction->getCreditAccount(),
                $transaction->getDateCreate(),
                $errorCode,
                $errorInfo
            ),
            TransactionNotSavedException::CODE_TRANSACTION_NOT_SAVED);
    }

}