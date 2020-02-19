<?php

namespace Db;

use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Laminas\ApiTools\Doctrine\ORM\QueryBuilder\Filter;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'api-tools-doctrine-orm-querybuilder-filter' => [
        'aliases' => [
            'eq'        => Filter\Equals::class,
            'neq'       => Filter\NotEquals::class,
            'lt'        => Filter\LessThan::class,
            'lte'       => Filter\LessThanOrEquals::class,
            'gt'        => Filter\GreaterThan::class,
            'gte'       => Filter\GreaterThanOrEquals::class,
            'isnull'    => Filter\IsNull::class,
            'isnotnull' => Filter\IsNotNull::class,
            'in'        => Filter\In::class,
            'notin'     => Filter\NotIn::class,
            'between'   => Filter\Between::class,
            'like'      => Filter\Like::class,
            'notlike'   => Filter\NotLike::class,
            'orx'       => Filter\OrX::class,
            'andx'      => Filter\AndX::class,
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
            Filter\OrX::class                 => InvokableFactory::class,
            Filter\AndX::class                => InvokableFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
           'db_driver' => [
                'class' => XmlDriver::class,
                'paths' => [__DIR__ . '/xml'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => 'db_driver',
                ],
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'json_exceptions' => [
            'display' => true,
            'ajax_only' => true,
            'show_trace' => true,
        ],
        'doctype'            => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
