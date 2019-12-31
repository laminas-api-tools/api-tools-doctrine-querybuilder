<?php

return array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'DoctrineMongoODMModule',
        'Db',
        'DbMongo',
        'Laminas\ApiTools\Doctrine\QueryBuilder',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            __DIR__ . '/local.php',
        ),
        'module_paths' => array(
            __DIR__ . '/../vendor',
            'DbMongo' => __DIR__ . '/module/DbMongo',
            'Db' => __DIR__ . '/module/Db',
            'Laminas\ApiTools\Doctrine\QueryBuilder' => __DIR__ . '/../../',
        ),
    ),
);
