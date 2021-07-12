<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\AbstractPluginManager;

class DefaultOdmFactory
{
    /**
     * Create and return DefaultOdm instance.
     *
     * @return DefaultOdm
     */
    public function __invoke(ContainerInterface $container)
    {
        if ($container instanceof AbstractPluginManager) {
            $container = $container->getServiceLocator() ?: $container;
        }

        $provider = new DefaultOdm();
        $provider->setServiceLocator($container);

        return $provider;
    }
}
