<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Auth\Middleware;


use Infrastructure\DTO\Identity;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\BaseSigner;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Hydrator\ClassMethods;

class TokenMiddleware implements RequestHandlerInterface
{

    const SIGN_KEY = self::class . '.token.key';
    const SIGN_PASSPHRASE = self::class . '.token.passphrase';
    /**
     * @var Builder
     */
    private $builder;
    /**
     * @var ClassMethods
     */
    private $hydrator;
    /**
     * @var BaseSigner
     */
    private $signer;
    private $key;

    /**
     * TokenMiddleware constructor.
     * @param Builder $builder
     * @param BaseSigner $signer
     * @param ClassMethods $hydrator
     * @param $key
     */
    public function __construct(Builder $builder, BaseSigner $signer, ClassMethods $hydrator, $key)
    {
        $this->builder = $builder;
        $this->hydrator = $hydrator;
        $this->signer = $signer;
        $this->key = $key;
    }


    /**
     * Handle the request and return a response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $authenticationInfo = $this->hydrator->hydrate($request->getParsedBody(), new Identity());

        //@todo move issuer to config and ENV
        $token = $this->builder
            ->setIssuer('billing')
            ->setAudience('billing')
            ->setIssuedAt(time())
            ->setExpiration(time()+3600)
            ->set('uuid', $authenticationInfo->getUuid())
            ->sign($this->signer, $this->key)
            ->getToken();

        $response = new EmptyResponse();
        return $response->withHeader('Authorization', ['Authorization' => (string) $token]);
    }
}