<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Billing\Handler;


use Domain\Model\Billing;
use Infrastructure\DTO\Credentials;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Hydrator\ClassMethods;

class History implements RequestHandlerInterface
{
    /**
     * @var Billing
     */
    private $billing;
    /**
     * @var ClassMethods
     */
    private $hydrator;

    /**
     * History constructor.
     * @param Billing $billing
     * @param ClassMethods $hydrator
     */
    public function __construct(Billing $billing, ClassMethods $hydrator)
    {
        $this->billing = $billing;
        $this->hydrator = $hydrator;
    }


    /**
     * Handle the request and return a response.
     * @todo enable pagination
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $credentials = $this->hydrator->hydrate($data, new Credentials());
        $result = $this->billing->transactionHistory($credentials);
        $data = [];
        foreach ($result as $transaction) {
            $data[] = $this->hydrator->extract($transaction);
        }
        return new JsonResponse($data);
    }
}