<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Doctrine\ORM\QueryBuilder\Filter;

use Laminas\ApiTools\Doctrine\ORM\QueryBuilder\Filter;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',
                'driverClass'   => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => [
                    'memory' => true,
                ],
            ],
        ],
    ],
    'api-tools-doctrine-orm-querybuilder-filter' => [
        'aliases' => [
            'eq'         => Filter\Equals::class,
            'neq'        => Filter\NotEquals::class,
            'lt'         => Filter\LessThan::class,
            'lte'        => Filter\LessThanOrEquals::class,
            'gt'         => Filter\GreaterThan::class,
            'gte'        => Filter\GreaterThanOrEquals::class,
            'isnull'     => Filter\IsNull::class,
            'isnotnull'  => Filter\IsNotNull::class,
            'in'         => Filter\In::class,
            'notin'      => Filter\NotIn::class,
            'between'    => Filter\Between::class,
            'like'       => Filter\Like::class,
            'notlike'    => Filter\NotLike::class,
            'ismemberof' => Filter\IsMemberOf::class,
            'orx'        => Filter\OrX::class,
            'andx'       => Filter\AndX::class,
            'innerjoin'  => Filter\InnerJoin::class,
            'leftjoin'  => Filter\LeftJoin::class,
        ],
        'factories' => [
            Filter\Equals::class              => InvokableFactory::class,
            Filter\NotEquals::class           => InvokableFactory::class,
            Filter\LessThan::class            => InvokableFactory::class,
            Filter\LessThanOrEquals::class    => InvokableFactory::class,
            Filter\GreaterThan::class         => InvokableFactory::class,
            Filter\GreaterThanOrEquals::class => InvokableFactory::class,
            Filter\IsNull::class              => InvokableFactory::class,
            Filter\IsNotNull::class           => InvokableFactory::class,
            Filter\In::class                  => InvokableFactory::class,
            Filter\NotIn::class               => InvokableFactory::class,
            Filter\Between::class             => InvokableFactory::class,
            Filter\Like::class                => InvokableFactory::class,
            Filter\NotLike::class             => InvokableFactory::class,
            Filter\IsMemberOf::class          => InvokableFactory::class,
            Filter\OrX::class                 => InvokableFactory::class,
            Filter\AndX::class                => InvokableFactory::class,
            Filter\InnerJoin::class           => InvokableFactory::class,
            Filter\LeftJoin::class            => InvokableFactory::class,
        ],
    ],
];
