<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Auth\Middleware;


use Auth\AuthAdapter;
use Infrastructure\DTO\Identity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Http\Response;

class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthenticationService
     */
    private $authentication;
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * AuthenticationMiddleware constructor.
     * @param AuthenticationService $authentication
     * @param AdapterInterface $adapter
     */
    public function __construct(AuthenticationService $authentication, AuthAdapter $adapter)
    {
        $this->authentication = $authentication;
        $this->adapter = $adapter;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($token = $request->getHeader('Authorization')) {
            $this->adapter->setToken($token[0]);

            $result =  $this->adapter->authenticate();
            if ($result->isValid()) {
                return $handler->handle($request->withAttribute(Identity::class, $result->getIdentity()));
            }
        }
        return new JsonResponse([], Response::STATUS_CODE_403);
    }
}