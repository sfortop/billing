<?php
/**
 * billing
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Proxy;


use Psr\Container\ContainerInterface;

class ContainerFactory
{
    public function __invoke(ContainerInterface $container) {
        return new Container($container);
    }
}