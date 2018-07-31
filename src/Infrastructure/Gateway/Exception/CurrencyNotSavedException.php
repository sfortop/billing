<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Infrastructure\Gateway\Exception;


use Domain\Entity\Currency;

class CurrencyNotSavedException extends AbstractNotSavedException
{

    public function __construct(Currency $currency)
    {
        parent::__construct(
            sprintf("Currency [%s] couldn't saved", $currency->getCode()),
            CurrencyNotSavedException::CODE_CURRENCY_NOT_SAVED);
    }

}