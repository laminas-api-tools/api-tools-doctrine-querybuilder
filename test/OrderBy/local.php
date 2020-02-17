<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Laminas\ApiTools\Doctrine\QueryBuilder\ORM\OrderBy;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',
                'driverClass'   => Driver::class,
                'params' => [
                    'memory' => true,
                ],
            ],
        ],
    ],
    'api-tools-doctrine-querybuilder-orderby-orm' => [
        'aliases' => [
            'field' => OrderBy\Field::class,
        ],
        'factories' => [
            OrderBy\Field::class => InvokableFactory::class,
        ],
    ],
];
