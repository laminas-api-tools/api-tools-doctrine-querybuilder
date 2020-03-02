<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Laminas\ApiTools\Doctrine\ODM\QueryBuilder\OrderBy;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'doctrine' => [
        'connection' => [
            'odm_default' => [
                'server' => 'mongo',
                'port' => '27017',
                'user' => '',
                'password' => '',
                'dbname' => 'laminas_doctrine_querybuilder_filter_test',
            ],
        ],
    ],
    'api-tools-doctrine-odm-querybuilder-orderby' => [
        'aliases' => [
            'field' => OrderBy\Field::class,
        ],
        'factories' => [
            OrderBy\Field::class => InvokableFactory::class,
        ],
    ],
];
