<?php

namespace Laminas\ApiTools\Doctrine\QueryBuilder;

use Laminas\ServiceManager\Factory\InvokableFactory;
use ZF\Doctrine\QueryBuilder\Filter\Service\ODMFilterManager;
use ZF\Doctrine\QueryBuilder\Filter\Service\ORMFilterManager;
use ZF\Doctrine\QueryBuilder\OrderBy\Service\ODMOrderByManager;
use ZF\Doctrine\QueryBuilder\OrderBy\Service\ORMOrderByManager;

return [
    'service_manager' => [
        'aliases'   => [
            'LaminasDoctrineQueryBuilderFilterManagerOrm'  => Filter\Service\ORMFilterManager::class,
            'LaminasDoctrineQueryBuilderFilterManagerOdm'  => Filter\Service\ODMFilterManager::class,
            'LaminasDoctrineQueryBuilderOrderByManagerOrm' => OrderBy\Service\ORMOrderByManager::class,
            'LaminasDoctrineQueryBuilderOrderByManagerOdm' => OrderBy\Service\ODMOrderByManager::class,

            // Legacy Zend Framework aliases
            'ZfDoctrineQueryBuilderFilterManagerOrm'  => 'LaminasDoctrineQueryBuilderFilterManagerOrm',
            'ZfDoctrineQueryBuilderFilterManagerOdm'  => 'LaminasDoctrineQueryBuilderFilterManagerOdm',
            'ZfDoctrineQueryBuilderOrderByManagerOrm' => 'LaminasDoctrineQueryBuilderOrderByManagerOrm',
            'ZfDoctrineQueryBuilderOrderByManagerOdm' => 'LaminasDoctrineQueryBuilderOrderByManagerOdm',
            ORMFilterManager::class                   => Filter\Service\ORMFilterManager::class,
            ODMFilterManager::class                   => Filter\Service\ODMFilterManager::class,
            ORMOrderByManager::class                  => OrderBy\Service\ORMOrderByManager::class,
            ODMOrderByManager::class                  => OrderBy\Service\ODMOrderByManager::class,
        ],
        'factories' => [
            Filter\Service\ORMFilterManager::class   => Filter\Service\ORMFilterManagerFactory::class,
            Filter\Service\ODMFilterManager::class   => Filter\Service\ODMFilterManagerFactory::class,
            OrderBy\Service\ORMOrderByManager::class => OrderBy\Service\ORMOrderByManagerFactory::class,
            OrderBy\Service\ODMOrderByManager::class => OrderBy\Service\ODMOrderByManagerFactory::class,
            Filter\ORM\TypeCaster::class             => InvokableFactory::class,
            Filter\ODM\TypeCaster::class             => InvokableFactory::class,
        ],
    ],
];
