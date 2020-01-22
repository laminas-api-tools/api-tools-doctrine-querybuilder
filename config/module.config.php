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
            'LaminasDoctrineQueryBuilderFilterManagerOdm' => Filter\Service\ODMFilterManager::class,
            'LaminasDoctrineQueryBuilderOrderByManagerOrm' => OrderBy\Service\ORMOrderByManager::class,
            'LaminasDoctrineQueryBuilderOrderByManagerOdm' => OrderBy\Service\ODMOrderByManager::class,

            // Legacy Zend Framework aliases
            'ZfDoctrineQueryBuilderFilterManagerOrm' => 'LaminasDoctrineQueryBuilderFilterManagerOrm',
            'ZfDoctrineQueryBuilderFilterManagerOdm' => 'LaminasDoctrineQueryBuilderFilterManagerOdm',
            'ZfDoctrineQueryBuilderOrderByManagerOrm' => 'LaminasDoctrineQueryBuilderOrderByManagerOrm',
            'ZfDoctrineQueryBuilderOrderByManagerOdm' => 'LaminasDoctrineQueryBuilderOrderByManagerOdm',
            \ZF\Doctrine\QueryBuilder\Filter\Service\ORMFilterManager::class => Filter\Service\ORMFilterManager::class,
            \ZF\Doctrine\QueryBuilder\Filter\Service\ODMFilterManager::class => Filter\Service\ODMFilterManager::class,
            \ZF\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManager::class => OrderBy\Service\ORMOrderByManager::class,
            \ZF\Doctrine\QueryBuilder\OrderBy\Service\ODMOrderByManager::class => OrderBy\Service\ODMOrderByManager::class,
        ],
        'factories' => [
            Filter\Service\ORMFilterManager::class => Filter\Service\ORMFilterManagerFactory::class,
            Filter\Service\ODMFilterManager::class => Filter\Service\ODMFilterManagerFactory::class,
            OrderBy\Service\ORMOrderByManager::class => OrderBy\Service\ORMOrderByManagerFactory::class,
            OrderBy\Service\ODMOrderByManager::class => OrderBy\Service\ODMOrderByManagerFactory::class,
            Filter\ORM\TypeCaster::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
            Filter\ODM\TypeCaster::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
];
