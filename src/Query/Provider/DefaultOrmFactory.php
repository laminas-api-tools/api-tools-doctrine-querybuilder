<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider;

use Interop\Container\ContainerInterface;

class DefaultOrmFactory
{
    /**
     * Create and return DefaultOrm instance.
     *
     * @param ContainerInterface $container
     * @return DefaultOrm
     */
    public function __invoke(ContainerInterface $container)
    {
        $provider = new DefaultOrm();
        $provider->setServiceLocator($container);

        return $provider;
    }
}
