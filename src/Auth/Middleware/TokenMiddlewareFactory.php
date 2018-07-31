<?php
/**
 * Copyright SuntechSoft (c) 2017-2018.
 */

/**
 * Created by Serhii Borodai <clarifying@gmail.com>
 */

namespace Auth\Middleware;


use Infrastructure\Exception\InvalidConfigException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use Lcobucci\JWT\Signer\Key;
use Psr\Container\ContainerInterface;
use Zend\Hydrator\ClassMethods;

class TokenMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return TokenMiddleware
     * @throws InvalidConfigException
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        if (!isset($config['auth'][TokenMiddleware::class][TokenMiddleware::SIGN_KEY])) {
            throw new InvalidConfigException();
        }
        return new TokenMiddleware(
            new Builder(),
            new Sha512(),
            $container->get(ClassMethods::class),
            new Key(
                $config['auth'][TokenMiddleware::SIGN_KEY],
                $config['auth'][TokenMiddleware::SIGN_PASSPHRASE]
            )
        );
    }

}