<?php

namespace Laminas\ApiTools\Doctrine\ORM\QueryBuilder;

use Interop\Container\ContainerInterface;

final class FilterManagerFactory
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $config = $container->get('config')['api-tools-doctrine-orm-querybuilder-filter'];

        return new FilterManager($container, $config);
    }
}
