<?php
/**
 * billing
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Domain\Model;


use Domain\Entity\Currency;
use Infrastructure\DTO\Payment;
use Infrastructure\Gateway\AccountGateway;
use Infrastructure\Gateway\CurrencyGateway;
use Infrastructure\Gateway\Exception\AccountNotFoundWithCurrencyException;
use Infrastructure\Gateway\Exception\AccountNotSavedException;

class Account
{
    /**
     * @var AccountGateway
     */
    private $accountGateway;
    /**
     * @var CurrencyGateway
     */
    private $currencyGateway;


    /**
     * Account constructor.
     * @param AccountGateway $accountGateway
     * @param CurrencyGateway $currencyGateway
     */
    public function __construct(AccountGateway $accountGateway, CurrencyGateway $currencyGateway)
    {
        $this->accountGateway = $accountGateway;
        $this->currencyGateway = $currencyGateway;
    }

    /**
     * @param $credential
     * @param Currency $currency
     * @return \Domain\Entity\Account
     * @throws AccountNotSavedException
     * @todo remove as unused
     */
    public function create($credential, Currency $currency)
    {
        /** @var \Domain\Entity\Account $account */
        $account = $this->accountGateway->create();
        $account->setCredential($credential);
        $account->setCurrencyCode($currency->getCode());

        $this->accountGateway->save($account);
        return $account;
    }

    /**
     * @param Payment $payment
     * @return \Domain\Entity\Account
     * @throws AccountNotSavedException
     */
    public function getDebit(Payment $payment)
    {

        if (!$payment->getFromCredentials()) {
            // if no from credentials then use main customer account
            $payment->setFromCredentials($payment->getCustomer());
            // for main counterpart account allow debt
            $debtIsAllowed = true;

        }

        try {
            $debitAccount = $this->accountGateway->findWithCurrency(
                $payment->getFromCredentials(),
                $payment->getCurrency()
            );
        } catch (AccountNotFoundWithCurrencyException $e) {
            $debitAccount = null;
        }

        if (!$debitAccount) {
            /** @var \Domain\Entity\Account $debitAccount */
            $debitAccount = $this->accountGateway->create();

            $debitAccount->setIsDebtAllowed($debtIsAllowed ?? false);
            $debitAccount->setCredential($payment->getFromCredentials());
            $debitAccount->setCustomer($payment->getCustomer());
            $debitAccount->setPaymentSystem($payment->getPaymentSystem());
            $debitAccount->setCurrencyCode($payment->getCurrency());

            $this->accountGateway->save($debitAccount);
        }

        return $debitAccount;
    }

    /**
     * @param Payment $payment
     * @return \Domain\Entity\Account
     * @throws AccountNotSavedException
     */
    public function getCredit(Payment $payment)
    {
        if (!$payment->getCredentials()) {
            // if no from credentials then use main customer account
            $payment->setCredentials($payment->getCustomer());
            // for main counterpart account allow debt
            $debtIsAllowed = true;
        }
        try {
            $creditAccount = $this->accountGateway->findWithCurrency(
                $payment->getCredentials(),
                $payment->getCurrency()
            );
        } catch (AccountNotFoundWithCurrencyException $e) {
            $creditAccount = null;
        }
        if (!$creditAccount) {
            /** @var \Domain\Entity\Account $creditAccount */
            $creditAccount = $this->accountGateway->create();
            $creditAccount->setIsDebtAllowed($debtIsAllowed ?? false);
            $creditAccount->setCredential($payment->getCredentials());
            $creditAccount->setCustomer($payment->getCustomer());
            $creditAccount->setPaymentSystem($payment->getPaymentSystem());
            $creditAccount->setCurrencyCode($payment->getCurrency());
            $this->accountGateway->save($creditAccount);
        }

        return $creditAccount;
    }

    /**
     * @param $debitAccount
     * @param $creditAccount
     * @param $amount
     * @return mixed
     */
    public function transferBalance($debitAccount, $creditAccount, $amount)
    {
        return $this->accountGateway->updateBalances($debitAccount, $creditAccount, $amount);
    }
}