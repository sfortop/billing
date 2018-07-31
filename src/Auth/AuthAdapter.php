<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Auth;


use Infrastructure\DTO\Identity;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Hydrator\ClassMethods;

class AuthAdapter implements AdapterInterface
{
    private $token;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var ClassMethods
     */
    private $hydrator;

    /**
     * AuthAdapter constructor.
     * @param Parser $parser
     * @param ClassMethods $hydrator
     */
    public function __construct(Parser $parser, ClassMethods $hydrator)
    {
        $this->parser = $parser;
        $this->hydrator = $hydrator;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $token = $this->parser->parse($this->token);

        //@todo move issuer to config and ENV
        $validationData = new ValidationData();
        $validationData->setAudience('billing');
        $validationData->setIssuer('billing');
        $validationData->setCurrentTime(time());
        if ($token->validate($validationData)) {
            return new Result(Result::SUCCESS, $this->hydrator->hydrate($token->getClaims(), new Identity()) );
        }

        return new Result(Result::FAILURE, $this->token, [Result::FAILURE => 'failed']);
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
}