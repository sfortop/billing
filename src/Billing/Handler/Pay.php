<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Billing\Handler;


use Domain\Entity\Transaction;
use Domain\Model\Billing;
use Domain\Model\Exception\BalanceTransferFailedException;
use Domain\Model\Exception\CredentialsRequiredException;
use Infrastructure\DTO\Identity;
use Infrastructure\DTO\Payment;
use Infrastructure\Gateway\Exception\AccountNotFoundWithCurrencyException;
use Infrastructure\Gateway\Exception\AccountNotSavedException;
use Infrastructure\Gateway\Exception\DuplicateKeyException;
use Infrastructure\Gateway\Exception\TransactionAlreadyExistsException;
use Infrastructure\Gateway\Exception\TransactionNotFoundException;
use Infrastructure\Gateway\Exception\TransactionNotSavedException;
use Infrastructure\Gateway\Exception\TransactionStatusNotSetException;
use Infrastructure\Response\JsonExceptionResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Hydrator\ClassMethods;

class Pay implements RequestHandlerInterface
{
    /**
     * @var ClassMethods
     */
    private $hydrator;
    /**
     * @var Billing
     */
    private $billing;

    /**
     * Pay constructor.
     * @param Billing $billing
     * @param ClassMethods $hydrator
     */
    public function __construct(Billing $billing, ClassMethods $hydrator)
    {
        $this->hydrator = $hydrator;
        $this->billing = $billing;
    }


    /**
     * Handle the request and return a response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $data = $request->getParsedBody();
        /** @var Payment $payment */
        $payment = $this->hydrator->hydrate($data, new Payment());
        $payment->setCustomer($request->getAttribute(Identity::class));

        /** @var Transaction $transaction */
        try {
            $transaction = $this->billing->pay($payment);
            $response = new JsonResponse(['payment' =>$this->hydrator->extract($transaction) ]);
        } catch (BalanceTransferFailedException |
            CredentialsRequiredException |
            AccountNotFoundWithCurrencyException |
            AccountNotSavedException |
            DuplicateKeyException |
            TransactionAlreadyExistsException |
            TransactionNotFoundException |
            TransactionNotSavedException |
            TransactionStatusNotSetException $e) {

            $response = new JsonExceptionResponse($e, 422);
        }
        return $response;
    }
}