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
    'api-tools-doctrine-querybuilder-orderby-orm' => array(
        'invokables' => array(
            'field' => 'Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ORM\Field',
        ),
    ),
    'api-tools-doctrine-querybuilder-orderby-odm' => array(
        'invokables' => array(
            'field' => 'Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ODM\Field',
        ),
    ),
);
