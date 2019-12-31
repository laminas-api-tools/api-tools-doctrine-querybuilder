<?php

date_default_timezone_set('UTC');

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'configuration' => 'orm_default',
                'eventmanager'  => 'orm_default',
                'driverClass'   => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'memory' => true,
                ),
            ),
            'odm_default' => array(
                'server' => 'localhost',
                'port' => '27017',
                'user' => '',
                'password' => '',
                'dbname' => 'laminas_doctrine_querybuilder_filter_test',
            ),
        ),
    ),
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
            'ismemberof' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\IsMemberOf',
            'orx' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\OrX',
            'andx' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\AndX',
            'innerjoin' => 'Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\InnerJoin',
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
);
