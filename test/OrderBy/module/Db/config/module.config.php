<?php

namespace Db;

return array(
    'api-tools-doctrine-querybuilder-filter-orm' => array(
        'invokables' => array(
            'eq' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\Equals',
            'neq' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\NotEquals',
            'lt' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\LessThan',
            'lte' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\LessThanOrEquals',
            'gt' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\GreaterThan',
            'gte' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\GreaterThanOrEquals',
            'isnull' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\IsNull',
            'isnotnull' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\IsNotNull',
            'in' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\In',
            'notin' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\NotIn',
            'between' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\Between',
            'like' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\Like',
            'notlike' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\NotLike',
            'orx' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\OrX',
            'andx' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\AndX',
        ),
    ),

    'api-tools-doctrine-querybuilder-filter-odm' => array(
        'invokables' => array(
            'eq' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\Equals',
            'neq' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\NotEquals',
            'lt' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\LessThan',
            'lte' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\LessThanOrEquals',
            'gt' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\GreaterThan',
            'gte' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\GreaterThanOrEquals',
            'isnull' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\IsNull',
            'isnotnull' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\IsNotNull',
            'in' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\In',
            'notin' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\NotIn',
            'between' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\Between',
            'like' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\Like',
            'regex' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ODM\Regex',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
           'db_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => array(__DIR__ . '/xml'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => 'db_driver',
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'json_exceptions' => array(
            'display' => true,
            'ajax_only' => true,
            'show_trace' => true
        ),

        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
