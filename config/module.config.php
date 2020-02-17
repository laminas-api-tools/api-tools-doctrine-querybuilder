<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\QueryBuilder\ORM;

return [
    'service_manager' => [
        'aliases' => [
            'LaminasDoctrineQueryBuilderFilterManagerOrm' => FilterManager::class,
            'LaminasDoctrineQueryBuilderOrderByManagerOrm' => OrderByManager::class,
            \ZF\Doctrine\QueryBuilder\ORM\FilterManager::class => FilterManager::class,
            \ZF\Doctrine\QueryBuilder\ORM\OrderByManager::class => OrderByManager::class,

            // Legacy Zend Framework aliases
            'ZfDoctrineQueryBuilderFilterManagerOrm' => 'LaminasDoctrineQueryBuilderFilterManagerOrm',
            'ZfDoctrineQueryBuilderOrderByManagerOrm' => 'LaminasDoctrineQueryBuilderOrderByManagerOrm',
        ],
        'factories' => [
            FilterManager::class => FilterManagerFactory::class,
            OrderByManager::class => OrderByManagerFactory::class,
        ],
    ],
];
