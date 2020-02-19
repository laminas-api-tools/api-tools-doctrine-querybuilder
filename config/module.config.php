<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ApiTools\Doctrine\ORM\QueryBuilder;

return [
    'service_manager' => [
        'factories' => [
            FilterManager::class => FilterManagerFactory::class,
            OrderByManager::class => OrderByManagerFactory::class,
        ],
    ],
];
