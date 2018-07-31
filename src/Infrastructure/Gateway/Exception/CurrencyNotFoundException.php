<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


class CurrencyNotFoundException extends AbstractException
{
    public function __construct($currencyCode)
    {
        parent::__construct(
            sprintf('Currency [%s] not found', $currencyCode),
            CurrencyNotFoundException::CODE_CURRENCY_NOT_FOUND);
    }

}