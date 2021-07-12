<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\AbstractPluginManager;

class DefaultOrmFactory
{
    /**
     * Create and return DefaultOrm instance.
     *
     * @return DefaultOrm
     */
    public function __invoke(ContainerInterface $container)
    {
        if ($container instanceof AbstractPluginManager) {
            $container = $container->getServiceLocator() ?: $container;
        }

        $provider = new DefaultOrm();
        $provider->setServiceLocator($container);

        return $provider;
    }
}
