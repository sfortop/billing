<?php
/**
 * billing
 *
 * @author Serhii Borodai <clarifying@gmail.com>
 */

namespace Proxy;


use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterServiceFactory;

class DbAdapterFactory
{
    /**
     * @param ContainerInterface $container
     * @return \Zend\Db\Adapter\Adapter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) {
        $factory = new AdapterServiceFactory();
        return $factory->createService($container->get(Container::class));
    }
}