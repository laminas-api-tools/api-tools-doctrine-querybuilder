<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder;

return [
    'service_manager' => [
        'aliases' => [
            'LaminasDoctrineQueryBuilderFilterManagerOrm' => Filter\Service\ORMFilterManager::class,
            'LaminasDoctrineQueryBuilderOrderByManagerOrm' => OrderBy\Service\ORMOrderByManager::class,

            // Legacy Zend Framework aliases
            'ZfDoctrineQueryBuilderFilterManagerOrm' => 'LaminasDoctrineQueryBuilderFilterManagerOrm',
            'ZfDoctrineQueryBuilderOrderByManagerOrm' => 'LaminasDoctrineQueryBuilderOrderByManagerOrm',
            \ZF\Doctrine\QueryBuilder\Filter\Service\ORMFilterManager::class => Filter\Service\ORMFilterManager::class,
            \ZF\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManager::class => OrderBy\Service\ORMOrderByManager::class,
        ],
        'factories' => [
            Filter\Service\ORMFilterManager::class => Filter\Service\ORMFilterManagerFactory::class,
            OrderBy\Service\ORMOrderByManager::class => OrderBy\Service\ORMOrderByManagerFactory::class,
        ],
    ],
];
