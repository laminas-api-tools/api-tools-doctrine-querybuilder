<?php

namespace Laminas\ApiTools\Doctrine\ODM\QueryBuilder;

use Interop\Container\ContainerInterface;

final class OrderByManagerFactory
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $config = $container->get('config')['api-tools-doctrine-odm-querybuilder-orderby'];

        return new OrderByManager($container, $config);
    }
}
