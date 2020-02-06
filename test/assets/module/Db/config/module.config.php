<?php

namespace Db;

use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Laminas\ApiTools\Doctrine\QueryBuilder\Filter;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'api-tools-doctrine-querybuilder-filter-orm' => [
        'aliases' => [
            'eq'        => Filter\ORM\Equals::class,
            'neq'       => Filter\ORM\NotEquals::class,
            'lt'        => Filter\ORM\LessThan::class,
            'lte'       => Filter\ORM\LessThanOrEquals::class,
            'gt'        => Filter\ORM\GreaterThan::class,
            'gte'       => Filter\ORM\GreaterThanOrEquals::class,
            'isnull'    => Filter\ORM\IsNull::class,
            'isnotnull' => Filter\ORM\IsNotNull::class,
            'in'        => Filter\ORM\In::class,
            'notin'     => Filter\ORM\NotIn::class,
            'between'   => Filter\ORM\Between::class,
            'like'      => Filter\ORM\Like::class,
            'notlike'   => Filter\ORM\NotLike::class,
            'orx'       => Filter\ORM\OrX::class,
            'andx'      => Filter\ORM\AndX::class,
        ],
        'factories' => [
            Filter\ORM\Equals::class              => InvokableFactory::class,
            Filter\ORM\NotEquals::class           => InvokableFactory::class,
            Filter\ORM\LessThan::class            => InvokableFactory::class,
            Filter\ORM\LessThanOrEquals::class    => InvokableFactory::class,
            Filter\ORM\GreaterThan::class         => InvokableFactory::class,
            Filter\ORM\GreaterThanOrEquals::class => InvokableFactory::class,
            Filter\ORM\IsNull::class              => InvokableFactory::class,
            Filter\ORM\IsNotNull::class           => InvokableFactory::class,
            Filter\ORM\In::class                  => InvokableFactory::class,
            Filter\ORM\NotIn::class               => InvokableFactory::class,
            Filter\ORM\Between::class             => InvokableFactory::class,
            Filter\ORM\Like::class                => InvokableFactory::class,
            Filter\ORM\NotLike::class             => InvokableFactory::class,
            Filter\ORM\OrX::class                 => InvokableFactory::class,
            Filter\ORM\AndX::class                => InvokableFactory::class,
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
